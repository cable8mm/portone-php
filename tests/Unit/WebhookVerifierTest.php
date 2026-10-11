<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Exception\WebhookVerificationException;
use Cable8mm\PortonePhp\UnrecognizedWebhook;
use Cable8mm\PortonePhp\WebhookTransactionPaid;
use Cable8mm\PortonePhp\WebhookVerifier;
use PHPUnit\Framework\TestCase;

final class WebhookVerifierTest extends TestCase
{
    private const SECRET = 'c2VjcmV0';

    public function test_valid_known_webhook_returns_typed_result(): void
    {
        $body = '{"type":"Transaction.Paid","timestamp":"2026-10-11T16:43:03.462959700Z","data":{"transactionId":"transaction-id","paymentId":"payment-id","storeId":"store-id"}}';
        [$id, $signature, $timestamp] = $this->headers($body);

        $result = (new WebhookVerifier(self::SECRET))->verify($body, $id, $signature, $timestamp);

        self::assertInstanceOf(WebhookTransactionPaid::class, $result);
        self::assertSame('payment-id', $result->data->paymentId);
        self::assertSame('transaction-id', $result->data->transactionId);
    }

    public function test_valid_unknown_webhook_exposes_decoded_body(): void
    {
        $body = '{"type":"Future.Event","data":{"value":"kept"}}';
        [$id, $signature, $timestamp] = $this->headers($body);

        $result = (new WebhookVerifier(self::SECRET))->verify($body, $id, $signature, $timestamp);

        self::assertInstanceOf(UnrecognizedWebhook::class, $result);
        self::assertSame('kept', $result->body['data']['value']);
    }

    public function test_body_and_signature_mutations_are_rejected(): void
    {
        $body = '{"type":"Future.Event"}';
        [$id, $signature, $timestamp] = $this->headers($body);
        $verifier = new WebhookVerifier(self::SECRET);

        try {
            $verifier->verify($body.' ', $id, $signature, $timestamp);
            self::fail('Expected body mutation to be rejected.');
        } catch (WebhookVerificationException) {
        }

        $this->expectException(WebhookVerificationException::class);
        $verifier->verify($body, $id, $signature.'x', $timestamp);
    }

    public function test_missing_and_out_of_tolerance_headers_are_rejected(): void
    {
        $verifier = new WebhookVerifier(self::SECRET);

        try {
            $verifier->verify('{}', null, null, null);
            self::fail('Expected missing headers to be rejected.');
        } catch (WebhookVerificationException) {
        }

        $this->expectException(WebhookVerificationException::class);
        $verifier->verify('{}', 'id', 'v1,invalid', (string) (time() - 301));
    }

    public function test_empty_secret_is_rejected(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new WebhookVerifier('');
    }

    /** @return array{string,string,string} */
    private function headers(string $body): array
    {
        $id = 'webhook-id';
        $timestamp = (string) time();
        $signature = base64_encode(hash_hmac('sha256', $id.'.'.$timestamp.'.'.$body, base64_decode(self::SECRET, true), true));

        return [$id, 'v1,'.$signature, $timestamp];
    }
}
