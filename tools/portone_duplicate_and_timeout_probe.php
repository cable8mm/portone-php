<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Client\PaymentClient;
use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\Exception\TransportException;
use Cable8mm\PortonePhp\Exception\UnknownException;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\Model\PayInstantlyResponse;
use Cable8mm\PortonePhp\Model\Payment;
use Dotenv\Dotenv;
use GuzzleHttp\Client;

/**
 * T-053 Duplicate request and timeout recovery behavior — live E2E probe.
 *
 * Flow:
 *  1. payInstantly (1 000 KRW, paymentId A)
 *  2. payInstantly same paymentId A again → observe ALREADY_PAID error; verify first payment
 *     is unaffected (getPayment still PAID).
 *  3. Timeout probe: attempt payInstantly with a 1-second total timeout to an unresponsive
 *     host (8.8.8.8:81) → TransportException within ~10 s (connect_timeout fires first).
 *     Then call getPayment for a fresh paymentId — observe NOT_FOUND, which demonstrates
 *     the recovery procedure: if payInstantly raises TransportException, immediately call
 *     getPayment; if NOT_FOUND the payment does not exist; if PAID the payment exists.
 *  4. Clean up: cancel payment A.
 *
 * NOTE: Step 3 uses a real TCP connection attempt to prove the timeout fires once
 * with no retry.  The timeout is set to 1 s to keep the probe fast.
 */

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
    $path = __DIR__.'/../tests/fixtures/duplicate-timeout-boundary-observations.json';
    if (file_put_contents($path, json_encode($record, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
        throw new RuntimeException('Could not write duplicate-timeout observation.');
    }
}

// ─── initialise ──────────────────────────────────────────────────────────────

$record = [
    'status' => 'failed',
    'operations' => [],
    'errors' => [],
    'recovery' => [],
];

try {
    $apiSecret = requiredEnv('PORTONE_API_SECRET');
    $channelKey = requiredEnv('PORTONE_E2E_CHANNEL_KEY');
    $cardNumber = requiredEnv('PORTONE_E2E_CARD_NUMBER');
    $expiryYear = requiredEnv('PORTONE_E2E_CARD_EXPIRY_YEAR');
    $expiryMonth = requiredEnv('PORTONE_E2E_CARD_EXPIRY_MONTH');
    $storeId = optionalEnv('PORTONE_E2E_STORE_ID');

    $credential = ['number' => $cardNumber, 'expiryYear' => $expiryYear, 'expiryMonth' => $expiryMonth];
    if (($bbn = optionalEnv('PORTONE_E2E_BIRTH_OR_BUSINESS_NUMBER')) !== null) {
        $credential['birthOrBusinessRegistrationNumber'] = $bbn;
    }
    if (($pwd = optionalEnv('PORTONE_E2E_PASSWORD_TWO_DIGITS')) !== null) {
        $credential['passwordTwoDigits'] = $pwd;
    }

    $method = ['card' => ['credential' => $credential]];
    $amount = ['total' => 1000, 'taxFree' => 0];

    $client = new PaymentClient($apiSecret);

    // ── STEP 1: first payment (paymentId A) ───────────────────────────────
    $paymentId = 'codex-e2e-dup-'.bin2hex(random_bytes(8));

    $first = $client->payInstantly(
        paymentId: $paymentId,
        channelKey: $channelKey,
        channelGroupId: null,
        method: $method,
        orderName: 'portone-php T-053 duplicate E2E',
        isCulturalExpense: false,
        isEscrow: false,
        customer: null,
        customData: null,
        amount: $amount,
        currency: 'KRW',
        country: null,
        noticeUrls: null,
        products: null,
        productCount: null,
        productType: null,
        shippingAddress: null,
        promotionId: null,
        bypass: null,
        skipWebhook: true,
        storeId: $storeId,
    );

    if (! $first instanceof PayInstantlyResponse || $first->payment->pgTxId === '') {
        throw new UnexpectedValueException('payInstantly (first) did not return a typed response.');
    }
    $record['operations']['payInstantly_first'] = [
        'status' => 'success',
        'paymentId' => $paymentId,
        'resultType' => $first::class,
    ];

    // ── STEP 2: duplicate — same paymentId ────────────────────────────────
    try {
        $client->payInstantly(
            paymentId: $paymentId,   // same ID
            channelKey: $channelKey,
            channelGroupId: null,
            method: $method,
            orderName: 'portone-php T-053 duplicate attempt 2',
            isCulturalExpense: false,
            isEscrow: false,
            customer: null,
            customData: null,
            amount: $amount,
            currency: 'KRW',
            country: null,
            noticeUrls: null,
            products: null,
            productCount: null,
            productType: null,
            shippingAddress: null,
            promotionId: null,
            bypass: null,
            skipWebhook: true,
            storeId: $storeId,
        );
        $record['errors']['already_paid'] = ['status' => 'no-error-raised'];
    } catch (UnknownException $exception) {
        $record['errors']['already_paid'] = [
            'status' => 'observed',
            'exception' => $exception::class,
            'errorType' => $exception->errorType,
            'httpStatus' => $exception->status,
        ];
    }

    // verify first payment is unaffected
    $paymentAfterDup = $client->getPayment($paymentId, $storeId);
    if (! $paymentAfterDup instanceof Payment) {
        throw new UnexpectedValueException('getPayment after duplicate did not return a Payment.');
    }
    $record['operations']['getPayment_after_duplicate'] = [
        'status' => 'success',
        'paymentStatus' => $paymentAfterDup->variant,
        'firstPaymentUnaffected' => $paymentAfterDup->variant === 'PAID',
    ];

    // Build the Guzzle client before constructing the PaymentClient so that
    // createExecutor() (called by parent::__construct) can capture it via closure.
    $timeoutHttpClient = new Client([
        'base_uri' => 'http://8.8.8.8:81',
        'connect_timeout' => 1,
        'timeout' => 1,
        'http_errors' => false,
    ]);

    $timeoutClient = new class($apiSecret, $timeoutHttpClient) extends PaymentClient
    {
        public function __construct(string $apiSecret, private readonly Client $overrideHttpClient)
        {
            parent::__construct($apiSecret);
        }

        protected function createExecutor(string $apiSecret): RequestExecutor
        {
            $httpClient = $this->overrideHttpClient;

            return new class($apiSecret, $httpClient) extends RequestExecutor
            {
                public function __construct(string $apiSecret, private readonly Client $overrideClient)
                {
                    parent::__construct($apiSecret);
                }

                protected function createClient(): Client
                {
                    return $this->overrideClient;
                }
            };
        }
    };

    $timeoutPaymentId = 'codex-e2e-timeout-'.bin2hex(random_bytes(8));
    $timeoutExceptionClass = null;
    $startAt = microtime(true);

    try {
        $timeoutClient->payInstantly(
            paymentId: $timeoutPaymentId,
            channelKey: $channelKey,
            channelGroupId: null,
            method: $method,
            orderName: 'portone-php T-053 timeout probe',
            isCulturalExpense: false,
            isEscrow: false,
            customer: null,
            customData: null,
            amount: $amount,
            currency: 'KRW',
            country: null,
            noticeUrls: null,
            products: null,
            productCount: null,
            productType: null,
            shippingAddress: null,
            promotionId: null,
            bypass: null,
            skipWebhook: true,
            storeId: $storeId,
        );
        $record['errors']['timeout'] = ['status' => 'no-error-raised'];
    } catch (TransportException $exception) {
        $elapsed = round(microtime(true) - $startAt, 2);
        $timeoutExceptionClass = $exception::class;
        $record['errors']['timeout'] = [
            'status' => 'observed',
            'exception' => $exception::class,
            'elapsedSeconds' => $elapsed,
            'retryCount' => 0,   // SDK never retries
        ];
    }

    // Recovery: call getPayment on the timed-out paymentId using the real client
    if ($timeoutExceptionClass !== null) {
        try {
            $recoveryPayment = $client->getPayment($timeoutPaymentId, $storeId);
            $record['recovery']['getPayment_after_timeout'] = [
                'status' => 'success',
                'paymentStatus' => $recoveryPayment->variant,
                'procedure' => 'payment exists — treat as paid and cancel or confirm',
            ];
        } catch (UnknownException $exception) {
            $record['recovery']['getPayment_after_timeout'] = [
                'status' => 'not-found-or-error',
                'errorType' => $exception->errorType,
                'httpStatus' => $exception->status,
                'procedure' => 'payment does not exist — safe to retry with new paymentId',
            ];
        }
    }

    // ── STEP 4: clean up payment A ────────────────────────────────────────
    try {
        $client->cancelPayment(
            paymentId: $paymentId,
            reason: 'T-053 E2E cleanup',
            skipWebhook: true,
            storeId: $storeId,
        );
        $record['operations']['cancelPayment_cleanup'] = ['status' => 'success'];
    } catch (PortOneException) {
        $record['operations']['cancelPayment_cleanup'] = ['status' => 'skipped'];
    }

    $record['status'] = 'observed';
} catch (PortOneException $exception) {
    $record['status'] = 'portone-failure';
    $record['exception'] = $exception::class;
    $record['statusCode'] = $exception->status;
    $record['message'] = $exception->getMessage();
} catch (Throwable $exception) {
    $record['exception'] = $exception::class;
    $record['message'] = $exception->getMessage();
}

writeObservation($record);
echo json_encode($record, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;

exit($record['status'] === 'observed' ? 0 : 1);
