<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Client\BillingKeyClient;
use Cable8mm\PortonePhp\Client\PaymentClient;
use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\Model\BillingKeyInfo;
use Cable8mm\PortonePhp\Model\BillingKeyInfoSummary;
use Cable8mm\PortonePhp\Model\BillingKeyPaymentSummary;
use Cable8mm\PortonePhp\Model\CancelPaymentResponse;
use Cable8mm\PortonePhp\Model\DeleteBillingKeyResponse;
use Cable8mm\PortonePhp\Model\IssueBillingKeyResponse;
use Cable8mm\PortonePhp\Model\Payment;
use Cable8mm\PortonePhp\Model\PaymentCancellation;
use Cable8mm\PortonePhp\Model\PayWithBillingKeyResponse;
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
    $path = __DIR__.'/../tests/fixtures/billing-key-lifecycle-boundary-observations.json';
    if (file_put_contents($path, json_encode($record, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
        throw new RuntimeException('Could not write billing-key lifecycle observation.');
    }
}

$record = [
    'status' => 'failed',
    'operations' => [],
];
$billingKey = null;
$paymentId = null;
$billingKeyClient = null;

try {
    $apiSecret = requiredEnv('PORTONE_API_SECRET');
    $channelKey = requiredEnv('PORTONE_E2E_CHANNEL_KEY');
    $channelGroupId = requiredEnv('PORTONE_E2E_CHANNEL_GROUP_ID');
    $cardNumber = requiredEnv('PORTONE_E2E_CARD_NUMBER');
    $expiryYear = requiredEnv('PORTONE_E2E_CARD_EXPIRY_YEAR');
    $expiryMonth = requiredEnv('PORTONE_E2E_CARD_EXPIRY_MONTH');
    $storeId = optionalEnv('PORTONE_E2E_STORE_ID');

    $customData = 'portone-php-billing-key-e2e-'.bin2hex(random_bytes(6));
    $paymentId = 'codex-billing-key-e2e-'.bin2hex(random_bytes(8));
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

    $info = $billingKeyClient->getBillingKeyInfo($billingKey, $storeId);
    if (! $info instanceof BillingKeyInfo || $info->variant !== 'ISSUED' || ($info->data['billingKey'] ?? null) !== $billingKey) {
        throw new UnexpectedValueException('getBillingKeyInfo did not return the issued billing-key identity.');
    }
    $record['operations']['getBillingKeyInfo'] = [
        'status' => 'success',
        'resultType' => $info::class,
        'billingKeyStatus' => $info->variant,
    ];

    $paymentClient = new PaymentClient($apiSecret);
    $paid = $paymentClient->payWithBillingKey(
        $paymentId,
        $billingKey,
        $channelKey,
        'portone-php billing-key E2E',
        null,
        $customData,
        ['total' => 1004, 'taxFree' => 0],
        'KRW',
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        true,
        $storeId,
    );
    if (! $paid instanceof PayWithBillingKeyResponse || ! $paid->payment instanceof BillingKeyPaymentSummary) {
        throw new UnexpectedValueException('payWithBillingKey did not return a typed payment summary.');
    }
    $record['operations']['payWithBillingKey'] = [
        'status' => 'success',
        'resultType' => $paid::class,
        'paymentPayloadType' => $paid->payment::class,
    ];

    $payment = $paymentClient->getPayment($paymentId, $storeId);
    if (! $payment instanceof Payment || ($payment->data['id'] ?? null) !== $paymentId || $payment->variant !== 'PAID') {
        throw new UnexpectedValueException('getPayment did not return the paid payment model.');
    }
    $record['operations']['getPayment'] = [
        'status' => 'success',
        'resultType' => $payment::class,
        'paymentStatus' => $payment->variant,
    ];

    $cancelled = $paymentClient->cancelPayment(
        $paymentId,
        null,
        null,
        null,
        'portone-php billing-key E2E cleanup',
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
    $record['operations']['cancelPayment'] = [
        'status' => 'success',
        'resultType' => $cancelled::class,
        'cancellationPayloadType' => $cancelled->cancellation::class,
        'cancellationStatus' => $cancelled->cancellation->variant,
    ];

    $finalPayment = null;
    for ($attempt = 1; $attempt <= 10; $attempt++) {
        $finalPayment = $paymentClient->getPaymentAsync($paymentId, $storeId)->wait();
        if ($finalPayment->variant === 'CANCELLED') {
            break;
        }
        usleep(2000000);
    }
    if (! $finalPayment instanceof Payment || $finalPayment->variant !== 'CANCELLED') {
        throw new UnexpectedValueException('Final getPayment did not observe CANCELLED status.');
    }
    $record['operations']['getPaymentAsync'] = [
        'status' => 'success',
        'resultType' => $finalPayment::class,
        'paymentStatus' => $finalPayment->variant,
    ];
    $record['status'] = 'observed';
} catch (PortOneException $exception) {
    $record['status'] = 'portone-failure';
    $record['exception'] = $exception::class;
    $record['statusCode'] = $exception->status;
    $record['errorType'] = $exception->errorType;
} catch (Throwable $exception) {
    $record['exception'] = $exception::class;
    $record['message'] = $exception->getMessage();
} finally {
    if ($billingKey !== null && $billingKeyClient instanceof BillingKeyClient) {
        try {
            $deleted = $billingKeyClient->deleteBillingKey($billingKey, 'portone-php billing-key E2E cleanup', 'ADMIN', null, optionalEnv('PORTONE_E2E_STORE_ID'));
            if (! $deleted instanceof DeleteBillingKeyResponse) {
                throw new UnexpectedValueException('deleteBillingKey did not return a typed response.');
            }
            $record['operations']['deleteBillingKey'] = [
                'status' => 'success',
                'resultType' => $deleted::class,
            ];

            try {
                $deletedInfo = $billingKeyClient->getBillingKeyInfo($billingKey, optionalEnv('PORTONE_E2E_STORE_ID'));
                if (! $deletedInfo instanceof BillingKeyInfo || $deletedInfo->variant !== 'DELETED') {
                    throw new UnexpectedValueException('Deleted billing key did not return the DELETED state.');
                }
                $record['operations']['getBillingKeyInfoAfterDelete'] = [
                    'status' => 'expected-deleted-state',
                    'resultType' => $deletedInfo::class,
                    'billingKeyStatus' => $deletedInfo->variant,
                ];
            } catch (PortOneException $exception) {
                $record['operations']['getBillingKeyInfoAfterDelete'] = [
                    'status' => 'expected-failure',
                    'exception' => $exception::class,
                    'statusCode' => $exception->status,
                    'errorType' => $exception->errorType,
                ];
            }
        } catch (Throwable $exception) {
            $record['status'] = 'cleanup-failure';
            $record['cleanupException'] = $exception::class;
        }
    }
}

writeObservation($record);
echo json_encode($record, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;

exit($record['status'] === 'observed' ? 0 : 1);
