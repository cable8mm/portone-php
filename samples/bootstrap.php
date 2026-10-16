<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Browser\BrowserPaymentRequest;
use Cable8mm\PortonePhp\Browser\RedirectResult;
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
    for ($depth = 0; is_string($customData) && $depth < 3; $depth++) {
        try {
            $customData = json_decode($customData, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return false;
        }
    }

    if (! is_array($customData) || ($customData['item'] ?? null) !== sampleItem()['id']) {
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

/**
 * 브라우저 결제창에 넘길 값을 만듭니다. 상점·채널은 공개 식별자라 쿼리로 받습니다.
 *
 * @return array{parameters: array<string,mixed>, paymentId: string}
 */
function sampleBrowserPaymentValues(string $storeId, string $channelKey, string $baseUrl): array
{
    $item = sampleItem();
    $paymentId = 'sample-'.bin2hex(random_bytes(8));
    $request = new BrowserPaymentRequest(
        storeId: $storeId,
        channelKey: $channelKey,
        paymentId: $paymentId,
        orderName: $item['name'],
        totalAmount: $item['price'],
        redirectUrl: $baseUrl.'/checkout/return',
        customerId: 'sample-'.bin2hex(random_bytes(8)),
        payMethod: 'CARD',
        currency: $item['currency'],
        forceRedirect: true,
        extra: ['customData' => ['item' => $item['id']]],
    );

    return ['parameters' => $request->toArray(), 'paymentId' => $paymentId];
}

function sampleBaseUrl(): string
{
    $scheme = (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? '127.0.0.1:8080';

    return $scheme.'://'.$host;
}

function sampleCheckoutPage(string $storeId, string $channelKey): never
{
    if ($storeId === '' || $channelKey === '') {
        sampleHtml(
            '<!doctype html><html lang="ko"><head><meta charset="utf-8"><title>PortOne PHP checkout sample</title></head><body>'
            .'<h1>Checkout sample</h1>'
            .'<form method="get" action="/checkout">'
            .'<label>Store ID <input name="storeId" value="'.sampleEscape($storeId).'"></label> '
            .'<label>Channel key <input name="channelKey" value="'.sampleEscape($channelKey).'"></label> '
            .'<button type="submit">Continue</button></form></body></html>',
        );
    }

    $item = sampleItem();
    $values = sampleBrowserPaymentValues($storeId, $channelKey, sampleBaseUrl());
    $parametersJson = json_encode(
        $values['parameters'],
        JSON_THROW_ON_ERROR | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE,
    );

    sampleHtml(
        '<!doctype html><html lang="ko"><head><meta charset="utf-8"><title>PortOne PHP checkout sample</title></head><body>'
        .'<h1>'.sampleEscape($item['name']).' '.number_format($item['price']).' '.sampleEscape($item['currency']).'</h1>'
        .'<p id="sample-error"></p>'
        .'<button id="sample-pay" type="button">Pay with PortOne</button>'
        .'<script id="sample-parameters" type="application/json">'.$parametersJson.'</script>'
        .'<script type="module">'
        .'import * as PortOne from "https://cdn.portone.io/v2/browser-sdk.esm.js";'
        .'const parameters = JSON.parse(document.querySelector("#sample-parameters").textContent);'
        .'document.querySelector("#sample-pay").addEventListener("click", async () => {'
        .'try { await PortOne.requestPayment(parameters); }'
        .'catch (error) { document.querySelector("#sample-error").textContent = String(error && error.message || error); }'
        .'});'
        .'</script></body></html>',
    );
}

/** @param array<string,mixed> $query */
function sampleCheckoutReturn(array $query): never
{
    try {
        $redirect = RedirectResult::fromQuery($query);
    } catch (InvalidArgumentException) {
        sampleText("Invalid redirect query.\n", 400);
    }

    if ($redirect->isFailure()) {
        sampleHtml(
            '<!doctype html><html lang="ko"><head><meta charset="utf-8"><title>Payment failed</title></head><body>'
            .'<h1>Payment failed</h1>'
            .'<p>code: '.sampleEscape((string) $redirect->code).'</p>'
            .'<p><a href="/checkout">Back to checkout</a></p></body></html>',
        );
    }

    try {
        $sync = sampleSyncPayment(samplePaymentClient(), $redirect->paymentId);
        $verified = 'verified '.sampleEscape($sync['status']);
    } catch (Throwable $exception) {
        $verified = 'not verified: '.sampleEscape($exception->getMessage());
    }

    sampleHtml(
        '<!doctype html><html lang="ko"><head><meta charset="utf-8"><title>Payment return</title></head><body>'
        .'<h1>Payment return</h1>'
        .'<p>paymentId: '.sampleEscape($redirect->paymentId).'</p>'
        .'<p>'.$verified.'</p></body></html>',
    );
}

function sampleHtml(string $html): never
{
    http_response_code(200);
    header('Content-Type: text/html; charset=utf-8');
    echo $html;
    exit;
}

function sampleEscape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
