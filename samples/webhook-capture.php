<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\WebhookTransactionPaid;

require_once __DIR__.'/bootstrap.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    sampleText("POST only\n", 405);
}

try {
    $webhook = sampleVerifyWebhook((string) file_get_contents('php://input'), getallheaders() ?: []);
    sampleJson([
        'verified' => true,
        'type' => $webhook instanceof WebhookTransactionPaid ? $webhook->type : 'unrecognized',
        'paymentId' => sampleWebhookPaymentId($webhook),
    ]);
} catch (Throwable $exception) {
    sampleJson(['verified' => false, 'error' => $exception->getMessage()], 400);
}
