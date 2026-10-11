<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\PortOneClient;

require __DIR__.'/../vendor/autoload.php';

$apiSecret = getenv('PORTONE_API_SECRET');
if ($apiSecret === false || $apiSecret === '') {
    fwrite(STDERR, "PORTONE_API_SECRET is not set.\n");
    exit(1);
}

$client = new PortOneClient($apiSecret);
$operations = [
    'getBankInfos' => static fn () => $client->common->getBankInfos(),
    'evaluateCheckoutProfile' => static fn () => $client->checkout->evaluateCheckoutProfile('missing-profile', 'KR', 'KRW', 1000),
    'createPaymentSession' => static fn () => $client->paymentSession->createPaymentSession('missing-store', 'missing-payment', 'missing-profile', null, 'KR', 'KRW', 1000, 'E2E probe'),
    'getPaymentSession' => static fn () => $client->paymentSession->getPaymentSession('missing-session'),
    'closePaymentSession' => static fn () => $client->paymentSession->closePaymentSession('missing-session'),
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
$recordPath = __DIR__.'/../tests/fixtures/openapi-additions-boundary-observations.json';
if (file_put_contents($recordPath, json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
    fwrite(STDERR, "Could not write OpenAPI addition observations.\n");
    exit(1);
}

echo json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;
