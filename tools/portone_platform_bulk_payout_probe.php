<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\BulkAccountTransferClient;
use Cable8mm\PortonePhp\BulkPayoutClient;
use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\PayoutClient;

require __DIR__.'/../vendor/autoload.php';

$apiSecret = getenv('PORTONE_API_SECRET');
if ($apiSecret === false || $apiSecret === '') {
    fwrite(STDERR, "PORTONE_API_SECRET is not set.\n");
    exit(1);
}

$bulkAccountTransfer = new BulkAccountTransferClient($apiSecret);
$bulkPayout = new BulkPayoutClient($apiSecret);
$payout = new PayoutClient($apiSecret);
$operations = [
    'getPlatformBulkAccountTransfers' => static fn () => $bulkAccountTransfer->getPlatformBulkAccountTransfers(false, false, ['number' => 0, 'size' => 1]),
    'getPlatformBulkPayouts' => static fn () => $bulkPayout->getPlatformBulkPayouts(false, false, ['number' => 0, 'size' => 1]),
    'getPlatformPayouts' => static fn () => $payout->getPlatformPayouts(false, false, ['number' => 0, 'size' => 1]),
    'completePlatformPayoutByPartnerSettlementIds' => static fn () => $payout->completePlatformPayoutByPartnerSettlementIds(false, '__codex_t012_missing_bulk_payout__', null, ['__codex_t012_missing_settlement__'], null, false),
];
$observations = [];

foreach ($operations as $name => $operation) {
    try {
        $result = $operation();
        $observations[$name] = [
            'status' => 'success',
            'resultType' => $result::class,
        ];
    } catch (PortOneException $exception) {
        $observations[$name] = [
            'status' => 'portone-failure',
            'exception' => $exception::class,
            'statusCode' => $exception->status,
        ];
    }
}

$output = [
    'status' => 'observed',
    'operations' => $observations,
];
$recordPath = __DIR__.'/../tests/fixtures/platform-bulk-payout-boundary-observations.json';
if (file_put_contents($recordPath, json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
    fwrite(STDERR, "Could not write bulk payout observations.\n");
    exit(1);
}

echo json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;
