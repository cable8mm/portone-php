<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\AdditionalFeatureClient;
use Cable8mm\PortonePhp\BillingKeyClient;
use Cable8mm\PortonePhp\CashReceiptClient;
use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\PaymentClient;
use Cable8mm\PortonePhp\PaymentScheduleClient;
use Cable8mm\PortonePhp\PromotionClient;

require __DIR__.'/../vendor/autoload.php';

$apiSecret = getenv('PORTONE_API_SECRET');
if ($apiSecret === false || $apiSecret === '') {
    fwrite(STDERR, "PORTONE_API_SECRET is not set.\n");
    exit(1);
}

$checks = [
    'payment' => static fn (): mixed => (new PaymentClient($apiSecret))->getPayments(['number' => 0, 'size' => 1]),
    'paymentEvents' => static fn (): mixed => (new PaymentClient($apiSecret))->getAllPaymentEventsByCursor(null, null, null, 1),
    'billingKey' => static fn (): mixed => (new BillingKeyClient($apiSecret))->getBillingKeyInfos(['number' => 0, 'size' => 1]),
    'cashReceipt' => static fn (): mixed => (new CashReceiptClient($apiSecret))->getCashReceipts(['number' => 0, 'size' => 1]),
    'additionalFeature' => static fn (): mixed => (new AdditionalFeatureClient($apiSecret))->getPgCardPromotions('__codex_t006_missing_channel__', 1),
    'paymentSchedule' => static fn (): mixed => (new PaymentScheduleClient($apiSecret))->getPaymentSchedules(['number' => 0, 'size' => 1]),
    'promotion' => static fn (): mixed => (new PromotionClient($apiSecret))->getPromotion('__codex_t006_missing_promotion__'),
];

$observations = [];
$failed = false;
foreach ($checks as $client => $check) {
    try {
        $result = $check();
        $observations[$client] = [
            'status' => 'success',
            'resultType' => $result::class,
        ];
    } catch (PortOneException $exception) {
        $observations[$client] = [
            'status' => 'portone-failure',
            'exception' => $exception::class,
            'statusCode' => $exception->status,
        ];
    } catch (Throwable $exception) {
        $observations[$client] = [
            'status' => 'unexpected-failure',
            'exception' => $exception::class,
        ];
        $failed = true;
    }
}

$record = [
    'status' => $failed ? 'failed' : 'observed',
    'clients' => $observations,
];
$recordPath = __DIR__.'/../tests/fixtures/payment-operations-boundary-observations.json';
if (file_put_contents($recordPath, json_encode($record, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
    fwrite(STDERR, "Could not write payment operation observations.\n");
    exit(1);
}

echo json_encode($record, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;

exit($failed ? 1 : 0);
