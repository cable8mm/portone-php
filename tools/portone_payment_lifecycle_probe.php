<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Client\PaymentClient;
use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\Model\CancelPaymentResponse;
use Cable8mm\PortonePhp\Model\PayInstantlyResponse;
use Cable8mm\PortonePhp\Model\Payment;
use Cable8mm\PortonePhp\Model\PaymentCancellation;
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
    $path = __DIR__.'/../tests/fixtures/payment-lifecycle-boundary-observations.json';
    if (file_put_contents($path, json_encode($record, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
        throw new RuntimeException('Could not write payment lifecycle observation.');
    }
}

$record = [
    'status' => 'failed',
    'operations' => [],
];

try {
    $apiSecret = requiredEnv('PORTONE_API_SECRET');
    $channelKey = requiredEnv('PORTONE_E2E_CHANNEL_KEY');
    $cardNumber = requiredEnv('PORTONE_E2E_CARD_NUMBER');
    $expiryYear = requiredEnv('PORTONE_E2E_CARD_EXPIRY_YEAR');
    $expiryMonth = requiredEnv('PORTONE_E2E_CARD_EXPIRY_MONTH');
    $storeId = optionalEnv('PORTONE_E2E_STORE_ID');

    $paymentId = 'codex-e2e-'.bin2hex(random_bytes(8));
    $client = new PaymentClient($apiSecret);
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

    $created = $client->payInstantly(
        $paymentId,
        $channelKey,
        null,
        ['card' => ['credential' => $credential]],
        'portone-php typed success E2E',
        false,
        false,
        null,
        'codex-e2e',
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
        true,
        $storeId,
    );
    if (! $created instanceof PayInstantlyResponse || $created->payment->pgTxId === '' || $created->payment->paidAt === '') {
        throw new UnexpectedValueException('payInstantly did not return a typed InstantPaymentSummary.');
    }
    $record['operations']['payInstantly'] = [
        'status' => 'success',
        'resultType' => $created::class,
        'paymentPayloadType' => $created->payment::class,
    ];

    $payment = $client->getPayment($paymentId, $storeId);
    if (! $payment instanceof Payment || $payment->data['id'] !== $paymentId) {
        throw new UnexpectedValueException('getPayment did not return the created Payment model.');
    }
    $record['operations']['getPayment'] = [
        'status' => 'success',
        'resultType' => $payment::class,
        'paymentStatus' => $payment->variant,
    ];

    $cancelled = $client->cancelPayment(
        $paymentId,
        null,
        null,
        null,
        'portone-php typed success E2E cleanup',
        'CUSTOMER',
        null,
        null,
        null,
        null,
        true,
        $storeId,
    );
    if (! $cancelled instanceof CancelPaymentResponse || ! $cancelled->cancellation instanceof PaymentCancellation) {
        throw new UnexpectedValueException('cancelPayment did not return a typed PaymentCancellation.');
    }
    $record['operations']['cancelPayment'] = [
        'status' => 'success',
        'resultType' => $cancelled::class,
        'cancellationPayloadType' => $cancelled->cancellation::class,
        'cancellationStatus' => $cancelled->cancellation->variant,
    ];

    $finalPayment = null;
    for ($attempt = 1; $attempt <= 10; $attempt++) {
        $finalPayment = $client->getPaymentAsync($paymentId, $storeId)->wait();
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
    $record['message'] = $exception->getMessage();
} catch (Throwable $exception) {
    $record['exception'] = $exception::class;
    $record['message'] = $exception->getMessage();
}

writeObservation($record);
echo json_encode($record, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;

exit($record['status'] === 'observed' ? 0 : 1);
