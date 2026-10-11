<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\WebhookTransactionPaid;

require_once __DIR__.'/bootstrap.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    sampleText("POST only\n", 405);
}

try {
    $body = (string) file_get_contents('php://input');
    $headers = getallheaders() ?: [];
    $webhook = sampleVerifyWebhook($body, $headers);
    $normalizedHeaders = [];
    foreach ($headers as $name => $value) {
        $normalizedHeaders[strtolower((string) $name)] = (string) $value;
    }
    $record = [
        'body' => $body,
        'headers' => [
            'webhook-id' => $normalizedHeaders['webhook-id'],
            'webhook-signature' => $normalizedHeaders['webhook-signature'],
            'webhook-timestamp' => $normalizedHeaders['webhook-timestamp'],
        ],
    ];
    file_put_contents(
        dirname(__DIR__).'/tests/fixtures/live-webhook.json',
        json_encode($record, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR).PHP_EOL,
        LOCK_EX,
    );
    sampleJson([
        'verified' => true,
        'type' => $webhook instanceof WebhookTransactionPaid ? $webhook->type : 'unrecognized',
        'paymentId' => sampleWebhookPaymentId($webhook),
        'fixtureRecorded' => true,
    ]);
} catch (Throwable $exception) {
    sampleJson(['verified' => false, 'error' => $exception->getMessage()], 400);
}
