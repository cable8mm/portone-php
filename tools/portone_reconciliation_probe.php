<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\ReconciliationClient;

require __DIR__.'/../vendor/autoload.php';

$apiSecret = getenv('PORTONE_API_SECRET');
if ($apiSecret === false || $apiSecret === '') {
    fwrite(STDERR, "PORTONE_API_SECRET is not set.\n");
    exit(1);
}

$client = new ReconciliationClient($apiSecret);
$dateRange = ['from' => '2026-01-01', 'until' => '2026-01-31'];
$operations = [];

foreach ([
    'getPaymentReconciliationSettlementVatReport' => static fn () => $client->getPaymentReconciliationSettlementVatReport($dateRange),
    'getPaymentReconciliationTransactionVatReport' => static fn () => $client->getPaymentReconciliationTransactionVatReport($dateRange),
] as $name => $operation) {
    try {
        $result = $operation();
        $operations[$name] = [
            'status' => 'success',
            'resultType' => $result::class,
        ];
    } catch (PortOneException $exception) {
        $operations[$name] = [
            'status' => 'portone-failure',
            'exception' => $exception::class,
            'statusCode' => $exception->status,
        ];
    }
}

$output = [
    'status' => 'observed',
    'operations' => $operations,
];
$recordPath = __DIR__.'/../tests/fixtures/reconciliation-boundary-observations.json';
if (file_put_contents($recordPath, json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
    fwrite(STDERR, "Could not write reconciliation observations.\n");
    exit(1);
}

echo json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;
