<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\AuthClient;
use Cable8mm\PortonePhp\Exception\PortOneException;

require __DIR__.'/../vendor/autoload.php';

$apiSecret = getenv('PORTONE_API_SECRET');
if ($apiSecret === false || $apiSecret === '') {
    fwrite(STDERR, "PORTONE_API_SECRET is not set.\n");
    exit(1);
}

$client = new AuthClient($apiSecret);
$operations = [];

try {
    $result = $client->loginViaApiSecret($apiSecret);
    $operations['loginViaApiSecret'] = [
        'status' => 'success',
        'resultType' => $result::class,
    ];
} catch (PortOneException $exception) {
    $operations['loginViaApiSecret'] = [
        'status' => 'portone-failure',
        'exception' => $exception::class,
        'statusCode' => $exception->status,
    ];
}

try {
    $result = $client->refreshToken('__codex_t009_invalid_refresh_token__');
    $operations['refreshToken'] = [
        'status' => 'success',
        'resultType' => $result::class,
    ];
} catch (PortOneException $exception) {
    $operations['refreshToken'] = [
        'status' => 'portone-failure',
        'exception' => $exception::class,
        'statusCode' => $exception->status,
    ];
}

$output = [
    'status' => 'observed',
    'operations' => $operations,
];
$recordPath = __DIR__.'/../tests/fixtures/auth-boundary-observations.json';
if (file_put_contents($recordPath, json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
    fwrite(STDERR, "Could not write auth observations.\n");
    exit(1);
}

echo json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;
