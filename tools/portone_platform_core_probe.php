<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Client\PlatformClient;
use Cable8mm\PortonePhp\Exception\PortOneException;

require __DIR__.'/../vendor/autoload.php';

$apiSecret = getenv('PORTONE_API_SECRET');
if ($apiSecret === false || $apiSecret === '') {
    fwrite(STDERR, "PORTONE_API_SECRET is not set.\n");
    exit(1);
}

$platform = new PlatformClient($apiSecret);
$operations = [
    'getPlatformSetting' => static fn () => $platform->getPlatformSetting(),
    'getB2bBusinessInfos' => static fn () => $platform->company->getB2bBusinessInfos(false, []),
    'getPlatformCompanyState' => static fn () => $platform->company->getPlatformCompanyState('0000000000', false),
    'getPlatformAccountHolder' => static fn () => $platform->account->getPlatformAccountHolder('SHINHAN', '0000000000', false),
    'getPlatformAccountTransfers' => static fn () => $platform->accountTransfer->getPlatformAccountTransfers(false, false, ['number' => 0, 'size' => 1]),
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
$recordPath = __DIR__.'/../tests/fixtures/platform-core-boundary-observations.json';
if (file_put_contents($recordPath, json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
    fwrite(STDERR, "Could not write platform observations.\n");
    exit(1);
}

echo json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;
