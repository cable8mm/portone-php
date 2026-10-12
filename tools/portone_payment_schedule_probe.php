<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Client\BillingKeyClient;
use Cable8mm\PortonePhp\Client\PaymentClient;
use Cable8mm\PortonePhp\Client\PaymentScheduleClient;
use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\Model\BillingKeyInfoSummary;
use Cable8mm\PortonePhp\Model\CancelPaymentResponse;
use Cable8mm\PortonePhp\Model\CreatePaymentScheduleResponse;
use Cable8mm\PortonePhp\Model\IssueBillingKeyResponse;
use Cable8mm\PortonePhp\Model\Payment;
use Cable8mm\PortonePhp\Model\PaymentCancellation;
use Cable8mm\PortonePhp\Model\PaymentSchedule;
use Cable8mm\PortonePhp\Model\RevokePaymentSchedulesResponse;
use Cable8mm\PortonePhp\Webhook\WebhookTransaction;
use Cable8mm\PortonePhp\Webhook\WebhookVerifier;
use Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

$root = dirname(__DIR__);
Dotenv::createImmutable($root)->safeLoad();

foreach (array_keys($_ENV) as $name) {
    if (is_string($_ENV[$name])) {
        putenv($name.'='.$_ENV[$name]);
    }
}

/** @return non-empty-string */
function requiredEnv(string $name): string
{
    $value = getenv($name);
    if ($value === false || $value === '') {
        throw new RuntimeException($name.' is not set in .env.');
    }

    return $value;
}

function optionalEnv(string $name): ?string
{
    $value = getenv($name);

    return $value === false || $value === '' ? null : $value;
}

/** @param array<string,mixed> $record */
function writeObservation(array $record): void
{
    $path = __DIR__.'/../tests/fixtures/payment-schedule-boundary-observations.json';
    if (file_put_contents($path, json_encode($record, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
        throw new RuntimeException('Could not write payment schedule observation.');
    }
}

/**
 * Poll the live-webhook.json fixture until the expected paymentId appears,
 * or the deadline (Unix timestamp) is exceeded.
 *
 * @return array<string,mixed>|null
 */
function pollWebhookFixture(string $expectedPaymentId, int $deadlineTimestamp): ?array
{
    $fixturePath = __DIR__.'/../tests/fixtures/live-webhook.json';
    while (time() < $deadlineTimestamp) {
        if (file_exists($fixturePath)) {
            $raw = file_get_contents($fixturePath);
            if ($raw !== false) {
                try {
                    $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
                    if (is_array($data)) {
                        $body = json_decode((string) ($data['body'] ?? '{}'), true, 512, JSON_THROW_ON_ERROR);
                        $paymentId = $body['data']['paymentId'] ?? null;
                        if ($paymentId === $expectedPaymentId) {
                            return $data;
                        }
                    }
                } catch (Throwable) {
                    // fixture not yet written or incomplete
                }
            }
        }
        echo '.';
        sleep(5);
    }

    return null;
}

$record = [
    'status' => 'failed',
    'operations' => [],
];
$billingKey = null;
$billingKeyClient = null;
$webhookScheduleId = null;
$webhookPaymentId = null;
$scheduleClient = null;
$paymentClient = null;

// Determine the ngrok webhook capture URL from CLI argument or ngrok local API.
$webhookCaptureUrl = $argv[1] ?? null;
if ($webhookCaptureUrl === null) {
    // Try to auto-discover from the running ngrok agent.
    $tunnelsJson = @file_get_contents('http://localhost:4040/api/tunnels');
    if ($tunnelsJson !== false) {
        $tunnels = json_decode($tunnelsJson, true, 512, JSON_THROW_ON_ERROR);
        $publicUrl = $tunnels['tunnels'][0]['public_url'] ?? null;
        if (is_string($publicUrl)) {
            $webhookCaptureUrl = rtrim($publicUrl, '/').'/webhook-capture.php';
        }
    }
}

if ($webhookCaptureUrl === null) {
    echo 'Usage: php portone_payment_schedule_probe.php <ngrok-webhook-capture-url>'.PHP_EOL;
    echo 'Or start ngrok (ngrok http 8899) and run without argument for auto-discovery.'.PHP_EOL;
    exit(1);
}

echo 'Webhook capture URL: '.$webhookCaptureUrl.PHP_EOL;

try {
    $apiSecret = requiredEnv('PORTONE_API_SECRET');
    $channelGroupId = requiredEnv('PORTONE_E2E_CHANNEL_GROUP_ID');
    $cardNumber = requiredEnv('PORTONE_E2E_CARD_NUMBER');
    $expiryYear = requiredEnv('PORTONE_E2E_CARD_EXPIRY_YEAR');
    $expiryMonth = requiredEnv('PORTONE_E2E_CARD_EXPIRY_MONTH');
    $storeId = optionalEnv('PORTONE_E2E_STORE_ID');
    $webhookSecret = requiredEnv('PORTONE_WEBHOOK_SECRET');

    $credential = [
        'number' => $cardNumber,
        'expiryYear' => $expiryYear,
        'expiryMonth' => $expiryMonth,
    ];
    if (($birthOrBusinessNumber = optionalEnv('PORTONE_E2E_BIRTH_OR_BUSINESS_NUMBER')) !== null) {
        $credential['birthOrBusinessRegistrationNumber'] = $birthOrBusinessNumber;
    }
    if (($passwordTwoDigits = optionalEnv('PORTONE_E2E_PASSWORD_TWO_DIGITS')) !== null) {
        $credential['passwordTwoDigits'] = $passwordTwoDigits;
    }

    // --- Step 1: Issue a billing key for the webhook-triggered schedule ---
    $customData = 'portone-php-schedule-e2e-'.bin2hex(random_bytes(6));
    $billingKeyClient = new BillingKeyClient($apiSecret);
    $issued = $billingKeyClient->issueBillingKey(
        ['card' => ['credential' => $credential]],
        null,
        $channelGroupId,
        null,
        $customData,
        null,
        null,
        true,
        $storeId,
    );
    if (! $issued instanceof IssueBillingKeyResponse || ! $issued->billingKeyInfo instanceof BillingKeyInfoSummary) {
        throw new UnexpectedValueException('issueBillingKey did not return a typed billing-key summary.');
    }
    $billingKey = $issued->billingKeyInfo->billingKey;
    $record['operations']['issueBillingKey'] = [
        'status' => 'success',
        'resultType' => $issued::class,
        'billingKeyPayloadType' => $issued->billingKeyInfo::class,
    ];
    echo PHP_EOL.'[1] Billing key issued.'.PHP_EOL;

    // --- Step 2: Create a schedule / revoke cycle (non-webhook, already observed) ---
    // Create then immediately revoke a schedule to confirm the typed round-trip.
    $revokePaymentId = 'codex-sched-revoke-e2e-'.bin2hex(random_bytes(6));
    $scheduleClient = new PaymentScheduleClient($apiSecret);
    $revokableTimeToPay = (new DateTimeImmutable('+10 minutes'))->format(DateTimeInterface::RFC3339_EXTENDED);
    $revokableSchedule = $scheduleClient->createPaymentSchedule(
        $revokePaymentId,
        [
            'billingKey' => $billingKey,
            'orderName' => 'portone-php schedule revoke E2E',
            'customer' => null,
            'customData' => $customData,
            'amount' => ['total' => 1004, 'taxFree' => 0],
            'currency' => 'KRW',
            'isCulturalExpense' => false,
            'isEscrow' => false,
        ],
        $revokableTimeToPay,
    );
    if (! $revokableSchedule instanceof CreatePaymentScheduleResponse || ! is_array($revokableSchedule->schedule)) {
        throw new UnexpectedValueException('createPaymentSchedule did not return a typed response.');
    }
    $revokeScheduleId = $revokableSchedule->schedule['id'] ?? null;
    if (! is_string($revokeScheduleId) || $revokeScheduleId === '') {
        throw new UnexpectedValueException('createPaymentSchedule did not return a schedule id.');
    }
    $record['operations']['createPaymentSchedule'] = [
        'status' => 'success',
        'resultType' => $revokableSchedule::class,
        'scheduleId' => $revokeScheduleId,
        'scheduleStatus' => $revokableSchedule->schedule['status'] ?? null,
    ];

    $retrieved = $scheduleClient->getPaymentSchedule($revokeScheduleId, $storeId);
    if (! $retrieved instanceof PaymentSchedule || $retrieved->variant !== 'SCHEDULED') {
        throw new UnexpectedValueException('getPaymentSchedule did not return SCHEDULED status.');
    }
    $record['operations']['getPaymentSchedule'] = [
        'status' => 'success',
        'resultType' => $retrieved::class,
        'scheduleStatus' => $retrieved->variant,
    ];

    $revokeResponse = $scheduleClient->revokePaymentSchedules(null, [$revokeScheduleId], $storeId);
    if (! $revokeResponse instanceof RevokePaymentSchedulesResponse
        || ! in_array($revokeScheduleId, $revokeResponse->revokedScheduleIds, true)) {
        throw new UnexpectedValueException('revokePaymentSchedules did not include the schedule id.');
    }
    $record['operations']['revokePaymentSchedules'] = [
        'status' => 'success',
        'resultType' => $revokeResponse::class,
        'revokedScheduleIds' => $revokeResponse->revokedScheduleIds,
        'revokedAt' => $revokeResponse->revokedAt,
    ];

    $revokedCheck = $scheduleClient->getPaymentScheduleAsync($revokeScheduleId, $storeId)->wait();
    if (! $revokedCheck instanceof PaymentSchedule || $revokedCheck->variant !== 'REVOKED') {
        throw new UnexpectedValueException('getPaymentSchedule after revoke did not return REVOKED status.');
    }
    $record['operations']['getPaymentScheduleAsync'] = [
        'status' => 'success',
        'resultType' => $revokedCheck::class,
        'scheduleStatus' => $revokedCheck->variant,
    ];
    echo '[2] Create/get/revoke schedule cycle confirmed.'.PHP_EOL;

    // --- Step 3: Create a schedule that executes in ~2 minutes ---
    // PortOne will fire a webhook; webhook-capture.php on the ngrok URL will receive it.
    $webhookPaymentId = 'codex-sched-webhook-e2e-'.bin2hex(random_bytes(6));
    // Schedule 2 minutes + 10 seconds from now to give enough startup time.
    $executeIn = 130;
    $timeToPay = (new DateTimeImmutable('+'.$executeIn.' seconds'))->format(DateTimeInterface::RFC3339_EXTENDED);
    $webhookScheduleResponse = $scheduleClient->createPaymentSchedule(
        $webhookPaymentId,
        [
            'billingKey' => $billingKey,
            'orderName' => 'portone-php schedule webhook E2E',
            'customer' => null,
            'customData' => $customData,
            'amount' => ['total' => 1004, 'taxFree' => 0],
            'currency' => 'KRW',
            'isCulturalExpense' => false,
            'isEscrow' => false,
        ],
        $timeToPay,
    );
    if (! $webhookScheduleResponse instanceof CreatePaymentScheduleResponse
        || ! is_array($webhookScheduleResponse->schedule)) {
        throw new UnexpectedValueException('createPaymentSchedule (webhook) did not return a typed response.');
    }
    $webhookScheduleId = $webhookScheduleResponse->schedule['id'] ?? null;
    if (! is_string($webhookScheduleId) || $webhookScheduleId === '') {
        throw new UnexpectedValueException('createPaymentSchedule (webhook) did not return a schedule id.');
    }
    $record['operations']['createPaymentScheduleForWebhook'] = [
        'status' => 'success',
        'resultType' => $webhookScheduleResponse::class,
        'scheduleId' => $webhookScheduleId,
        'scheduledPaymentId' => $webhookPaymentId,
        'timeToPay' => $timeToPay,
        'webhookCaptureUrl' => $webhookCaptureUrl,
    ];
    echo '[3] Webhook schedule created ('.$webhookScheduleId.').'.PHP_EOL;
    echo '    timeToPay: '.$timeToPay.PHP_EOL;
    echo '    Waiting for schedule execution (up to '.($executeIn + 90).' seconds)...'.PHP_EOL;

    // --- Step 4: Wait for PortOne to execute the schedule and fire the webhook ---
    $deadlineTimestamp = time() + $executeIn + 90;
    $webhookFixture = pollWebhookFixture($webhookPaymentId, $deadlineTimestamp);

    if ($webhookFixture === null) {
        throw new RuntimeException(
            'Webhook for payment '.$webhookPaymentId.' was not received within the deadline. '.
            'Ensure the PortOne console has the webhook URL set to: '.$webhookCaptureUrl
        );
    }
    echo PHP_EOL.'[4] Webhook received.'.PHP_EOL;

    // --- Step 5: Verify the received webhook with WebhookVerifier ---
    $verifier = new WebhookVerifier($webhookSecret);
    $webhookBody = (string) ($webhookFixture['body'] ?? '');
    $webhookHeaders = $webhookFixture['headers'] ?? [];
    $webhookResult = $verifier->verify(
        $webhookBody,
        $webhookHeaders['webhook-id'] ?? null,
        $webhookHeaders['webhook-signature'] ?? null,
        $webhookHeaders['webhook-timestamp'] ?? null,
    );
    $record['operations']['webhookVerifier'] = [
        'status' => 'success',
        'resultType' => $webhookResult::class,
        'isTypedKnownWebhook' => $webhookResult instanceof WebhookTransaction,
        'webhookPaymentId' => $webhookResult instanceof WebhookTransaction
            ? $webhookResult->data->paymentId
            : ($webhookResult->body['data']['paymentId'] ?? null),
    ];
    echo '[5] Webhook verified by WebhookVerifier: '.$webhookResult::class.PHP_EOL;

    // --- Step 6: Retrieve the payment created by the schedule ---
    $paymentClient = new PaymentClient($apiSecret);
    $scheduledPayment = null;
    for ($attempt = 1; $attempt <= 12; $attempt++) {
        try {
            $scheduledPayment = $paymentClient->getPayment($webhookPaymentId, $storeId);
            if ($scheduledPayment->variant === 'PAID') {
                break;
            }
        } catch (PortOneException) {
            // payment may not be fully settled yet
        }
        sleep(5);
    }
    if (! $scheduledPayment instanceof Payment || $scheduledPayment->variant !== 'PAID') {
        throw new UnexpectedValueException(
            'getPayment for the scheduled payment did not return PAID. Got: '.
            ($scheduledPayment instanceof Payment ? $scheduledPayment->variant : 'null')
        );
    }
    $record['operations']['getScheduledPayment'] = [
        'status' => 'success',
        'resultType' => $scheduledPayment::class,
        'paymentStatus' => $scheduledPayment->variant,
        'paymentId' => $scheduledPayment->data['id'] ?? null,
    ];
    echo '[6] Scheduled payment retrieved: '.$scheduledPayment->variant.PHP_EOL;

    // --- Step 7: Cancel the payment created by the schedule ---
    $cancelled = $paymentClient->cancelPayment(
        $webhookPaymentId,
        null,
        null,
        null,
        'portone-php schedule webhook E2E cleanup',
        'CUSTOMER',
        null,
        null,
        null,
        null,
        true,
        $storeId,
    );
    if (! $cancelled instanceof CancelPaymentResponse || ! $cancelled->cancellation instanceof PaymentCancellation) {
        throw new UnexpectedValueException('cancelPayment did not return a typed cancellation.');
    }
    $record['operations']['cancelScheduledPayment'] = [
        'status' => 'success',
        'resultType' => $cancelled::class,
        'cancellationPayloadType' => $cancelled->cancellation::class,
        'cancellationStatus' => $cancelled->cancellation->variant,
    ];
    echo '[7] Scheduled payment cancelled: '.$cancelled->cancellation->variant.PHP_EOL;

    $record['status'] = 'observed';
} catch (PortOneException $exception) {
    $record['status'] = 'portone-failure';
    $record['exception'] = $exception::class;
    $record['statusCode'] = $exception->status;
    $record['errorType'] = $exception->errorType;
    $record['message'] = $exception->getMessage();
    echo PHP_EOL.'PortOne error: '.$exception->getMessage().PHP_EOL;
} catch (Throwable $exception) {
    $record['exception'] = $exception::class;
    $record['message'] = $exception->getMessage();
    echo PHP_EOL.'Error: '.$exception->getMessage().PHP_EOL;
} finally {
    // Best-effort: revoke the webhook schedule if it was created but not yet executed.
    if ($webhookScheduleId !== null && $scheduleClient instanceof PaymentScheduleClient
        && $record['status'] !== 'observed') {
        try {
            $scheduleClient->revokePaymentSchedules(null, [$webhookScheduleId], optionalEnv('PORTONE_E2E_STORE_ID'));
        } catch (Throwable) {
            // ignore
        }
    }
    // Best-effort: delete the billing key.
    if ($billingKey !== null && $billingKeyClient instanceof BillingKeyClient) {
        try {
            $billingKeyClient->deleteBillingKey(
                $billingKey,
                'portone-php schedule webhook E2E cleanup',
                'ADMIN',
                null,
                optionalEnv('PORTONE_E2E_STORE_ID'),
            );
        } catch (Throwable) {
            // ignore
        }
    }
}

writeObservation($record);
echo json_encode($record, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;

exit($record['status'] === 'observed' ? 0 : 1);
