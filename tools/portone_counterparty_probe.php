<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Client\CounterpartyClient;
use Cable8mm\PortonePhp\Exception\PortOneException;

require __DIR__.'/../vendor/autoload.php';

$apiSecret = getenv('PORTONE_API_SECRET');
if ($apiSecret === false || $apiSecret === '') {
    fwrite(STDERR, "PORTONE_API_SECRET is not set.\n");
    exit(1);
}

$client = new CounterpartyClient($apiSecret);
$operations = [
    'getB2bCounterparties' => static fn () => $client->getB2bCounterparties(true, ['number' => 0, 'size' => 1], []),
    'getB2bCounterpartiesAsync' => static fn () => $client->getB2bCounterpartiesAsync(true, ['number' => 0, 'size' => 1], [])->wait(),
    'getB2bCounterparty' => static fn () => $client->getB2bCounterparty('__codex_t016_missing_counterparty__', true),
    'getB2bCounterpartyAsync' => static fn () => $client->getB2bCounterpartyAsync('__codex_t016_missing_counterparty__', true)->wait(),
    'getB2bCounterpartyCertificateRegistrationUrl' => static fn () => $client->getB2bCounterpartyCertificateRegistrationUrl('0000000000', true),
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
$recordPath = __DIR__.'/../tests/fixtures/counterparty-boundary-observations.json';
if (file_put_contents($recordPath, json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
    fwrite(STDERR, "Could not write counterparty observations.\n");
    exit(1);
}

echo json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;
