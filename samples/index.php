<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Webhook\WebhookTransaction;

require_once __DIR__.'/bootstrap.php';

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($path === '/webhook-capture.php') {
    return false;
}

if ($path === '/' && $method === 'GET') {
    sampleText("PortOne PHP server sample is ready.\n\n".
        "GET  /api/item\n".
        "POST /api/payment/complete {\"paymentId\":\"...\"}\n".
        "POST /api/payment/webhook\n");
}

if ($path === '/api/item' && $method === 'GET') {
    sampleJson(sampleItem());
}

if ($path === '/api/payment/complete' && $method === 'POST') {
    $request = json_decode((string) file_get_contents('php://input'), true);
    if (! is_array($request) || ! is_string($request['paymentId'] ?? null)) {
        sampleJson(['error' => 'paymentId must be a string.'], 400);
    }

    try {
        sampleJson(sampleSyncPayment(samplePaymentClient(), $request['paymentId']));
    } catch (Throwable $exception) {
        sampleFailure($exception);
    }
}

if ($path === '/api/payment/webhook' && $method === 'POST') {
    $body = (string) file_get_contents('php://input');

    try {
        $webhook = sampleVerifyWebhook($body, getallheaders() ?: []);
        $paymentId = sampleWebhookPaymentId($webhook);
        $sync = null;
        if ($paymentId !== null && getenv('PORTONE_API_SECRET') !== false && getenv('PORTONE_API_SECRET') !== '') {
            try {
                $sync = sampleSyncPayment(samplePaymentClient(), $paymentId);
            } catch (Throwable $exception) {
                $sync = ['status' => 'not-synchronized', 'reason' => $exception->getMessage()];
            }
        }

        sampleJson([
            'verified' => true,
            'type' => $webhook instanceof WebhookTransaction ? $webhook->type : 'unrecognized',
            'paymentId' => $paymentId,
            'sync' => $sync,
        ]);
    } catch (Throwable $exception) {
        sampleJson(['verified' => false, 'error' => $exception->getMessage()], 400);
    }
}

sampleText("Not found\n", 404);
