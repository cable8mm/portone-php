<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Webhook\UnrecognizedWebhook;
use Cable8mm\PortonePhp\Webhook\WebhookTransaction;
use Cable8mm\PortonePhp\Webhook\WebhookVerifier;
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__, 2).'/samples/bootstrap.php';

final class SampleTest extends TestCase
{
    public function test_sample_item_matches_the_reference_server_scenario(): void
    {
        self::assertSame([
            'id' => 'shoes',
            'name' => '신발',
            'price' => 1000,
            'currency' => 'KRW',
        ], sampleItem());
    }

    public function test_paid_payment_must_match_the_sample_item(): void
    {
        self::assertTrue(samplePaymentMatchesItem([
            'customData' => '{"item":"shoes"}',
            'orderName' => '신발',
            'amount' => ['total' => 1000],
            'currency' => 'KRW',
        ]));
        self::assertFalse(samplePaymentMatchesItem([
            'customData' => '{"item":"other"}',
            'orderName' => '신발',
            'amount' => ['total' => 1000],
            'currency' => 'KRW',
        ]));
    }

    public function test_sample_webhook_flow_uses_the_public_verifier(): void
    {
        $body = '{"type":"Transaction.Paid","timestamp":"2026-10-12T00:00:00Z","data":{"transactionId":"transaction","paymentId":"payment","storeId":"store"}}';
        $id = 'msg-sample';
        $timestamp = (string) time();
        $secret = base64_encode('sample-test-secret');
        putenv("PORTONE_WEBHOOK_SECRET=whsec_{$secret}");
        $signature = 'v1,'.base64_encode(hash_hmac('sha256', $id.'.'.$timestamp.'.'.$body, 'sample-test-secret', true));

        $webhook = sampleVerifyWebhook($body, [
            'Webhook-Id' => $id,
            'Webhook-Timestamp' => $timestamp,
            'Webhook-Signature' => $signature,
        ]);

        self::assertInstanceOf(WebhookTransaction::class, $webhook);
        self::assertSame('payment', sampleWebhookPaymentId($webhook));

        $unknownBody = str_replace('Transaction.Paid', 'Future.Event', $body);
        $unknownSignature = 'v1,'.base64_encode(hash_hmac('sha256', $id.'.'.$timestamp.'.'.$unknownBody, 'sample-test-secret', true));
        $unknown = (new WebhookVerifier("whsec_{$secret}"))->verify($unknownBody, $id, $unknownSignature, $timestamp);

        self::assertInstanceOf(UnrecognizedWebhook::class, $unknown);
        self::assertSame('Future.Event', $unknown->body['type']);
        putenv('PORTONE_WEBHOOK_SECRET');
    }
}
