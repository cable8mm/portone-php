<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Client\IdentityVerificationClient;
use Cable8mm\PortonePhp\Exception\PortOneException;

require __DIR__.'/../vendor/autoload.php';

$apiSecret = getenv('PORTONE_API_SECRET');
if ($apiSecret === false || $apiSecret === '') {
    fwrite(STDERR, "PORTONE_API_SECRET is not set.\n");
    exit(1);
}

$client = new IdentityVerificationClient($apiSecret);
try {
    $result = $client->getIdentityVerifications(['number' => 0, 'size' => 1]);
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
    $result = $client->getIdentityVerificationsAsync(['number' => 0, 'size' => 1])->wait();
    $asyncRecord = ['status' => 'success', 'resultType' => $result::class];
} catch (PortOneException $exception) {
    $asyncRecord = ['status' => 'portone-failure', 'exception' => $exception::class, 'statusCode' => $exception->status];
}

$output = [
    'status' => 'observed',
    'operation' => 'getIdentityVerifications',
    'result' => $record,
    'asyncResult' => $asyncRecord,
];
$recordPath = __DIR__.'/../tests/fixtures/identity-verification-boundary-observations.json';
if (file_put_contents($recordPath, json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
    fwrite(STDERR, "Could not write identity verification observations.\n");
    exit(1);
}

echo json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;
