<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\PgSpecificClient;

require __DIR__.'/../vendor/autoload.php';

$apiSecret = getenv('PORTONE_API_SECRET');
if ($apiSecret === false || $apiSecret === '') {
    fwrite(STDERR, "PORTONE_API_SECRET is not set.\n");
    exit(1);
}

$client = new PgSpecificClient($apiSecret);
try {
    $result = $client->getKakaopayPaymentOrder('__codex_t008_missing_transaction__', '__codex_t008_missing_channel__');
    $record = [
        'status' => 'success',
        'resultType' => $result::class,
    ];
} catch (PortOneException $exception) {
    $record = [
        'status' => 'portone-failure',
        'exception' => $exception::class,
        'statusCode' => $exception->status,
    ];
}

try {
    $result = $client->getKakaopayPaymentOrderAsync('__codex_t008_missing_transaction__', '__codex_t008_missing_channel__')->wait();
    $asyncRecord = ['status' => 'success', 'resultType' => $result::class];
} catch (PortOneException $exception) {
    $asyncRecord = ['status' => 'portone-failure', 'exception' => $exception::class, 'statusCode' => $exception->status];
}

$output = [
    'status' => 'observed',
    'operation' => 'getKakaopayPaymentOrder',
    'result' => $record,
    'asyncResult' => $asyncRecord,
];
$recordPath = __DIR__.'/../tests/fixtures/pg-specific-boundary-observations.json';
if (file_put_contents($recordPath, json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
    fwrite(STDERR, "Could not write PG-specific observations.\n");
    exit(1);
}

echo json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;
