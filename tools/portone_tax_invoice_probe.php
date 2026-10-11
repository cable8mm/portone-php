<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\TaxInvoiceClient;

require __DIR__.'/../vendor/autoload.php';

$apiSecret = getenv('PORTONE_API_SECRET');
if ($apiSecret === false || $apiSecret === '') {
    fwrite(STDERR, "PORTONE_API_SECRET is not set.\n");
    exit(1);
}

$client = new TaxInvoiceClient($apiSecret);
$operations = [
    'getB2bTaxInvoices' => static fn () => $client->getB2bTaxInvoices(true, 0, 1, [], []),
    'getB2bTaxInvoicesAsync' => static fn () => $client->getB2bTaxInvoicesAsync(true, 0, 1, [], [])->wait(),
    'createB2bFileUploadUrl' => static fn () => $client->createB2bFileUploadUrl(true, 'codex-t015-invoice.csv'),
    'createB2bFileUploadUrlAsync' => static fn () => $client->createB2bFileUploadUrlAsync(true, 'codex-t015-invoice.csv')->wait(),
    'getB2bTaxInvoice' => static fn () => $client->getB2bTaxInvoice('__codex_t015_missing_tax_invoice__', null, null, true),
    'getB2bTaxInvoiceAsync' => static fn () => $client->getB2bTaxInvoiceAsync('__codex_t015_missing_tax_invoice__', null, null, true)->wait(),
];
$observations = [];

foreach ($operations as $name => $operation) {
    try {
        $result = $operation();
        $observations[$name] = [
            'status' => 'success',
            'resultType' => is_object($result) ? $result::class : get_debug_type($result),
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
$recordPath = __DIR__.'/../tests/fixtures/tax-invoice-boundary-observations.json';
if (file_put_contents($recordPath, json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
    fwrite(STDERR, "Could not write tax invoice observations.\n");
    exit(1);
}

echo json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;
