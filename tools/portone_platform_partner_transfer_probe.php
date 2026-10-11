<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\PartnerClient;
use Cable8mm\PortonePhp\PartnerSettlementClient;
use Cable8mm\PortonePhp\TransferClient;

require __DIR__.'/../vendor/autoload.php';

$apiSecret = getenv('PORTONE_API_SECRET');
if ($apiSecret === false || $apiSecret === '') {
    fwrite(STDERR, "PORTONE_API_SECRET is not set.\n");
    exit(1);
}

$partnerSettlement = new PartnerSettlementClient($apiSecret);
$partner = new PartnerClient($apiSecret);
$transfer = new TransferClient($apiSecret);
$operations = [
    'getPlatformPartnerSettlements' => static fn () => $partnerSettlement->getPlatformPartnerSettlements(false, ['number' => 0, 'size' => 1], [], false),
    'getPlatformPartner' => static fn () => $partner->getPlatformPartner('__codex_t013_missing_partner__', false),
    'getPlatformTransferSummaries' => static fn () => $transfer->getPlatformTransferSummaries(false, ['number' => 0, 'size' => 1], []),
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
$recordPath = __DIR__.'/../tests/fixtures/platform-partner-transfer-boundary-observations.json';
if (file_put_contents($recordPath, json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
    fwrite(STDERR, "Could not write partner transfer observations.\n");
    exit(1);
}

echo json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;
