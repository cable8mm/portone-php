<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Client\PaymentClient;
use Cable8mm\PortonePhp\Exception\WebhookVerificationException;
use Cable8mm\PortonePhp\Webhook\UnrecognizedWebhook;
use Cable8mm\PortonePhp\Webhook\WebhookTransaction;
use Cable8mm\PortonePhp\Webhook\WebhookVerifier;
use Dotenv\Dotenv;

require_once dirname(__DIR__).'/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();
foreach (['PORTONE_API_SECRET', 'PORTONE_WEBHOOK_SECRET'] as $name) {
    if (isset($_ENV[$name]) && getenv($name) === false) {
        putenv($name.'='.$_ENV[$name]);
    }
}

/** @return array{id: string, name: string, price: int, currency: string} */
function sampleItem(): array
{
    return [
        'id' => 'shoes',
        'name' => '신발',
        'price' => 1000,
        'currency' => 'KRW',
    ];
}

function sampleApiSecret(): string
{
    $secret = getenv('PORTONE_API_SECRET');
    if ($secret === false || $secret === '') {
        throw new RuntimeException('PORTONE_API_SECRET is not set.');
    }

    return $secret;
}

function sampleWebhookSecret(): string
{
    $secret = getenv('PORTONE_WEBHOOK_SECRET');
    if ($secret === false || $secret === '') {
        throw new RuntimeException('PORTONE_WEBHOOK_SECRET is not set.');
    }

    return $secret;
}

function samplePaymentClient(): PaymentClient
{
    return new PaymentClient(sampleApiSecret());
}

function sampleWebhookVerifier(): WebhookVerifier
{
    return new WebhookVerifier(sampleWebhookSecret());
}

/** @return array{status: string} */
function sampleSyncPayment(PaymentClient $client, string $paymentId): array
{
    $payment = $client->getPayment($paymentId);
    $status = $payment->data['status'] ?? null;

    if (! is_string($status)) {
        throw new RuntimeException('The PortOne response did not contain a payment status.');
    }

    if ($status === 'PAID' && ! samplePaymentMatchesItem($payment->data)) {
        throw new RuntimeException('The paid payment does not match the sample item.');
    }

    if (! in_array($status, ['PAID', 'VIRTUAL_ACCOUNT_ISSUED'], true)) {
        throw new RuntimeException('The payment is not complete.');
    }

    return ['status' => $status];
}

/** @param array<string,mixed> $payment */
function samplePaymentMatchesItem(array $payment): bool
{
    $customData = $payment['customData'] ?? null;
    if (! is_string($customData)) {
        return false;
    }

    try {
        $decoded = json_decode($customData, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        return false;
    }

    if (! is_array($decoded) || ($decoded['item'] ?? null) !== sampleItem()['id']) {
        return false;
    }

    $item = sampleItem();

    return ($payment['orderName'] ?? null) === $item['name']
        && ($payment['amount']['total'] ?? null) === $item['price']
        && ($payment['currency'] ?? null) === $item['currency'];
}

/** @param array<string,mixed> $headers */
function sampleVerifyWebhook(string $body, array $headers): WebhookTransaction|UnrecognizedWebhook
{
    $id = sampleHeader($headers, 'webhook-id');
    $signature = sampleHeader($headers, 'webhook-signature');
    $timestamp = sampleHeader($headers, 'webhook-timestamp');

    return sampleWebhookVerifier()->verify($body, $id, $signature, $timestamp);
}

/** @param array<string,mixed> $headers */
function sampleHeader(array $headers, string $name): string
{
    foreach ($headers as $key => $value) {
        if (strtolower((string) $key) === $name && is_scalar($value)) {
            return (string) $value;
        }
    }

    throw new WebhookVerificationException("Missing {$name} header.");
}

function sampleWebhookPaymentId(WebhookTransaction|UnrecognizedWebhook $webhook): ?string
{
    if ($webhook instanceof WebhookTransaction) {
        return $webhook->data->paymentId;
    }

    $paymentId = $webhook->body['data']['paymentId'] ?? null;

    return is_string($paymentId) ? $paymentId : null;
}

function sampleJson(mixed $value, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).PHP_EOL;
    exit;
}

function sampleText(string $value, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: text/plain; charset=utf-8');
    echo $value;
    exit;
}

function sampleFailure(Throwable $exception): never
{
    sampleJson(['error' => $exception->getMessage()], 502);
}
