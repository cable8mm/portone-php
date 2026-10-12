<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Exception\WebhookVerificationException;
use Cable8mm\PortonePhp\Webhook\UnrecognizedWebhook;
use Cable8mm\PortonePhp\Webhook\WebhookBillingKey;
use Cable8mm\PortonePhp\Webhook\WebhookTransaction;
use Cable8mm\PortonePhp\Webhook\WebhookVerifier;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * T-054 — Real webhook verification and fixture capture.
 *
 * Covers:
 *  - All Transaction.* types return WebhookTransaction with correct type field.
 *  - All BillingKey.* types return WebhookBillingKey with correct type field.
 *  - Unknown types return UnrecognizedWebhook with decoded body preserved.
 *  - Multiple signatures: accepted when any one is valid, rejected when none are.
 *  - Timestamp tolerance boundary: just inside (±299 s), just outside (±301 s).
 *  - Future-dated timestamp rejected.
 *  - Malformed (non-integer) timestamp rejected.
 *  - Missing headers rejected.
 *  - Body mutations of any kind (whitespace, re-serialisation, encoding) rejected.
 *  - Empty webhookSecret rejected at construction (ERR-002).
 *  - Sanitized fixture payloads decode correctly.
 */
final class WebhookVerifierTest extends TestCase
{
    private const SECRET = 'c2VjcmV0';   // base64("secret")

    // ─── webhook type dispatch ────────────────────────────────────────────

    #[DataProvider('transactionTypeProvider')]
    public function test_all_transaction_types_return_webhook_transaction(string $type): void
    {
        $body = $this->body($type, ['paymentId' => 'p', 'storeId' => 's', 'transactionId' => 'tx']);
        [$id, $sig, $ts] = $this->headers($body);

        $result = (new WebhookVerifier(self::SECRET))->verify($body, $id, $sig, $ts);

        self::assertInstanceOf(WebhookTransaction::class, $result);
        self::assertSame($type, $result->type);
    }

    /** @return list<array{string}> */
    public static function transactionTypeProvider(): array
    {
        return array_map(static fn (string $t): array => [$t], WebhookTransaction::KNOWN_TYPES);
    }

    public function test_transaction_paid_data_fields_are_decoded(): void
    {
        $body = $this->body('Transaction.Paid', ['paymentId' => 'pay-01', 'storeId' => 'store-01', 'transactionId' => 'tx-01']);
        [$id, $sig, $ts] = $this->headers($body);

        $result = (new WebhookVerifier(self::SECRET))->verify($body, $id, $sig, $ts);

        self::assertInstanceOf(WebhookTransaction::class, $result);
        self::assertSame('pay-01', $result->data->paymentId);
        self::assertSame('store-01', $result->data->storeId);
        self::assertSame('tx-01', $result->data->transactionId);
        self::assertNull($result->data->cancellationId);
    }

    public function test_transaction_cancelled_carries_cancellation_id(): void
    {
        $body = $this->body('Transaction.Cancelled', [
            'paymentId' => 'pay-01', 'storeId' => 'store-01',
            'transactionId' => 'tx-01', 'cancellationId' => 'cancel-01',
        ]);
        [$id, $sig, $ts] = $this->headers($body);

        $result = (new WebhookVerifier(self::SECRET))->verify($body, $id, $sig, $ts);

        self::assertInstanceOf(WebhookTransaction::class, $result);
        self::assertSame('cancel-01', $result->data->cancellationId);
    }

    #[DataProvider('billingKeyTypeProvider')]
    public function test_all_billing_key_types_return_webhook_billing_key(string $type): void
    {
        $body = $this->body($type, ['billingKey' => 'bk-01', 'storeId' => 'store-01']);
        [$id, $sig, $ts] = $this->headers($body);

        $result = (new WebhookVerifier(self::SECRET))->verify($body, $id, $sig, $ts);

        self::assertInstanceOf(WebhookBillingKey::class, $result);
        self::assertSame($type, $result->type);
        self::assertSame('bk-01', $result->data->billingKey);
        self::assertSame('store-01', $result->data->storeId);
    }

    /** @return list<array{string}> */
    public static function billingKeyTypeProvider(): array
    {
        return array_map(static fn (string $t): array => [$t], WebhookBillingKey::KNOWN_TYPES);
    }

    public function test_unknown_type_returns_unrecognized_webhook_with_body_preserved(): void
    {
        $body = '{"type":"Future.UnknownEvent","data":{"value":"kept"}}';
        [$id, $sig, $ts] = $this->headers($body);

        $result = (new WebhookVerifier(self::SECRET))->verify($body, $id, $sig, $ts);

        self::assertInstanceOf(UnrecognizedWebhook::class, $result);
        self::assertSame('kept', $result->body['data']['value']);
    }

    // ─── fixture payloads ─────────────────────────────────────────────────

    public function test_sanitized_fixture_payloads_decode_correctly(): void
    {
        $fixtures = json_decode(
            (string) file_get_contents(__DIR__.'/../../tests/fixtures/webhook-payloads-sanitized.json'),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );

        $verifier = new WebhookVerifier(self::SECRET);

        foreach ($fixtures as $key => $payload) {
            if (str_starts_with($key, '_')) {
                continue;
            }

            $body = json_encode($payload, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
            [$id, $sig, $ts] = $this->headers($body);
            $result = $verifier->verify($body, $id, $sig, $ts);

            if (str_starts_with($key, 'Transaction.')) {
                self::assertInstanceOf(WebhookTransaction::class, $result, "Fixture $key not typed as WebhookTransaction.");
                self::assertSame($key, $result->type);
            } elseif (str_starts_with($key, 'BillingKey.')) {
                self::assertInstanceOf(WebhookBillingKey::class, $result, "Fixture $key not typed as WebhookBillingKey.");
                self::assertSame($key, $result->type);
            }
        }
    }

    // ─── multiple signatures ──────────────────────────────────────────────

    public function test_multiple_signatures_accepted_when_any_one_is_valid(): void
    {
        $body = '{"type":"Future.Event"}';
        $id = 'webhook-id';
        $ts = (string) time();
        $valid = $this->sign($id, $ts, $body);
        $multiSig = 'v1,invalidBase64== v1,'.$valid;   // first bad, second good

        $result = (new WebhookVerifier(self::SECRET))->verify($body, $id, $multiSig, $ts);

        self::assertInstanceOf(UnrecognizedWebhook::class, $result);
    }

    public function test_multiple_signatures_rejected_when_none_is_valid(): void
    {
        $body = '{"type":"Future.Event"}';
        $id = 'webhook-id';
        $ts = (string) time();
        $multiSig = 'v1,'.base64_encode('bad1').' v1,'.base64_encode('bad2');

        $this->expectException(WebhookVerificationException::class);
        (new WebhookVerifier(self::SECRET))->verify($body, $id, $multiSig, $ts);
    }

    public function test_signature_with_unknown_version_prefix_is_skipped(): void
    {
        $body = '{"type":"Future.Event"}';
        $id = 'webhook-id';
        $ts = (string) time();
        $valid = $this->sign($id, $ts, $body);
        $multiSig = 'v2,someOtherSig v1,'.$valid;   // v2 unknown prefix — skipped

        $result = (new WebhookVerifier(self::SECRET))->verify($body, $id, $multiSig, $ts);

        self::assertInstanceOf(UnrecognizedWebhook::class, $result);
    }

    // ─── timestamp boundary ───────────────────────────────────────────────

    public function test_timestamp_just_inside_past_tolerance_is_accepted(): void
    {
        $body = '{"type":"Future.Event"}';
        $id = 'webhook-id';
        $ts = (string) (time() - 299);   // 1 s inside 300 s tolerance
        $sig = 'v1,'.$this->sign($id, $ts, $body);

        $result = (new WebhookVerifier(self::SECRET))->verify($body, $id, $sig, $ts);

        self::assertInstanceOf(UnrecognizedWebhook::class, $result);
    }

    public function test_timestamp_just_outside_past_tolerance_is_rejected(): void
    {
        $body = '{"type":"Future.Event"}';
        $id = 'webhook-id';
        $ts = (string) (time() - 301);   // 1 s outside 300 s tolerance

        $this->expectException(WebhookVerificationException::class);
        (new WebhookVerifier(self::SECRET))->verify($body, $id, 'v1,anything', $ts);
    }

    public function test_future_dated_timestamp_just_inside_tolerance_is_accepted(): void
    {
        $body = '{"type":"Future.Event"}';
        $id = 'webhook-id';
        $ts = (string) (time() + 299);
        $sig = 'v1,'.$this->sign($id, $ts, $body);

        $result = (new WebhookVerifier(self::SECRET))->verify($body, $id, $sig, $ts);

        self::assertInstanceOf(UnrecognizedWebhook::class, $result);
    }

    public function test_future_dated_timestamp_just_outside_tolerance_is_rejected(): void
    {
        $body = '{"type":"Future.Event"}';
        $id = 'webhook-id';
        $ts = (string) (time() + 301);   // 1 s beyond future tolerance

        $this->expectException(WebhookVerificationException::class);
        (new WebhookVerifier(self::SECRET))->verify($body, $id, 'v1,anything', $ts);
    }

    public function test_malformed_timestamp_is_rejected(): void
    {
        $body = '{"type":"Future.Event"}';

        $this->expectException(WebhookVerificationException::class);
        (new WebhookVerifier(self::SECRET))->verify($body, 'id', 'v1,sig', 'not-a-number');
    }

    public function test_negative_timestamp_is_rejected(): void
    {
        $body = '{"type":"Future.Event"}';

        $this->expectException(WebhookVerificationException::class);
        (new WebhookVerifier(self::SECRET))->verify($body, 'id', 'v1,sig', '-1');
    }

    // ─── body mutations ───────────────────────────────────────────────────

    public function test_trailing_whitespace_in_body_is_rejected(): void
    {
        $body = '{"type":"Future.Event"}';
        [$id, $sig, $ts] = $this->headers($body);

        $this->expectException(WebhookVerificationException::class);
        (new WebhookVerifier(self::SECRET))->verify($body.' ', $id, $sig, $ts);
    }

    public function test_leading_whitespace_in_body_is_rejected(): void
    {
        $body = '{"type":"Future.Event"}';
        [$id, $sig, $ts] = $this->headers($body);

        $this->expectException(WebhookVerificationException::class);
        (new WebhookVerifier(self::SECRET))->verify(' '.$body, $id, $sig, $ts);
    }

    public function test_re_serialised_body_with_different_key_order_is_rejected(): void
    {
        $body = '{"type":"Future.Event","data":{"a":1}}';
        [$id, $sig, $ts] = $this->headers($body);
        // Re-serialise changes key order
        $reserialized = json_encode(json_decode($body, true), JSON_THROW_ON_ERROR);

        // Only test this if re-serialisation actually changes the string
        if ($reserialized === $body) {
            self::markTestSkipped('Re-serialisation did not change the body.');
        }

        $this->expectException(WebhookVerificationException::class);
        (new WebhookVerifier(self::SECRET))->verify($reserialized, $id, $sig, $ts);
    }

    public function test_body_with_unicode_escape_instead_of_literal_is_rejected(): void
    {
        $body = '{"type":"Future.Event","note":"hello"}';
        [$id, $sig, $ts] = $this->headers($body);
        $escaped = '{"type":"Future.Event","note":"\u0068ello"}';   // same value, different encoding

        $this->expectException(WebhookVerificationException::class);
        (new WebhookVerifier(self::SECRET))->verify($escaped, $id, $sig, $ts);
    }

    // ─── missing headers ──────────────────────────────────────────────────

    public function test_missing_all_headers_is_rejected(): void
    {
        $this->expectException(WebhookVerificationException::class);
        (new WebhookVerifier(self::SECRET))->verify('{}', null, null, null);
    }

    public function test_missing_id_is_rejected(): void
    {
        $body = '{"type":"Future.Event"}';
        [, $sig, $ts] = $this->headers($body);

        $this->expectException(WebhookVerificationException::class);
        (new WebhookVerifier(self::SECRET))->verify($body, null, $sig, $ts);
    }

    // ─── empty secret ─────────────────────────────────────────────────────

    public function test_empty_secret_is_rejected(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new WebhookVerifier('');
    }

    public function test_invalid_base64_secret_is_rejected(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new WebhookVerifier('not-valid-base64!!!');
    }

    // ─── helpers ─────────────────────────────────────────────────────────

    /**
     * @param  array<string,mixed>  $data
     */
    private function body(string $type, array $data, ?string $timestamp = null): string
    {
        return json_encode([
            'type' => $type,
            'timestamp' => $timestamp ?? '2026-10-12T15:00:00Z',
            'data' => $data,
        ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
    }

    /** @return array{string,string,string} */
    private function headers(string $body): array
    {
        $id = 'webhook-id';
        $ts = (string) time();
        $sig = 'v1,'.$this->sign($id, $ts, $body);

        return [$id, $sig, $ts];
    }

    private function sign(string $id, string $ts, string $body): string
    {
        $secretBytes = base64_decode(self::SECRET, true);

        return base64_encode(hash_hmac('sha256', $id.'.'.$ts.'.'.$body, $secretBytes, true));
    }
}
