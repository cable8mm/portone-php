<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Exception\WebhookVerificationException;
use Cable8mm\PortonePhp\Webhook\UnrecognizedWebhook;
use Cable8mm\PortonePhp\Webhook\WebhookSigner;
use Cable8mm\PortonePhp\Webhook\WebhookVerifier;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * T-062 — WebhookSigner for testing and local checks.
 *
 * Covers:
 *  - Round trip: WebhookSigner headers pass WebhookVerifier::verify() with and without whsec_.
 *  - Changing only the body, msgId, timestamp, or secret fails verification.
 *  - Standard Webhooks official test vector.
 *  - Generated msgId and timestamp defaults.
 *  - Invalid secrets rejected at construction (ERR-010).
 *  - __debugInfo and serialization safety.
 */
final class WebhookSignerTest extends TestCase
{
    private const SECRET = 'MfKQ9r8GKYqrTwjUPD8ILPZIo2LaLaSw';

    private const OTHER_SECRET = 'c2VjcmV0';   // base64("secret")

    private const BODY = '{"type":"Test.Signed","data":{"id":1}}';

    // ─── round trip ──────────────────────────────────────────────────────

    #[DataProvider('secretProvider')]
    public function test_signed_headers_pass_verifier(string $secret): void
    {
        $headers = (new WebhookSigner($secret))->headers(self::BODY);

        $webhook = (new WebhookVerifier($secret))->verify(
            self::BODY,
            $headers[WebhookVerifier::HEADER_ID],
            $headers[WebhookVerifier::HEADER_SIGNATURE],
            $headers[WebhookVerifier::HEADER_TIMESTAMP],
        );

        $this->assertInstanceOf(UnrecognizedWebhook::class, $webhook);
        $this->assertSame(json_decode(self::BODY, true), $webhook->body);
    }

    #[DataProvider('secretProvider')]
    public function test_prefixed_and_plain_secrets_produce_the_same_signature(string $secret): void
    {
        $this->assertSame(
            (new WebhookSigner(self::SECRET))->sign('msg-1', 1614265330, self::BODY),
            (new WebhookSigner($secret))->sign('msg-1', 1614265330, self::BODY),
        );
    }

    /** @return array<string,array{string}> */
    public static function secretProvider(): array
    {
        return [
            'plain' => [self::SECRET],
            'whsec_ prefix' => ['whsec_'.self::SECRET],
        ];
    }

    // ─── single-field changes fail verification ──────────────────────────

    public function test_changed_body_fails_verification(): void
    {
        $headers = (new WebhookSigner(self::SECRET))->headers(self::BODY);

        $this->expectException(WebhookVerificationException::class);
        $this->verify(self::SECRET, self::BODY.' ', $headers);
    }

    public function test_changed_msg_id_fails_verification(): void
    {
        $headers = (new WebhookSigner(self::SECRET))->headers(self::BODY, 'msg-original');
        $headers[WebhookVerifier::HEADER_ID] = 'msg-changed';

        $this->expectException(WebhookVerificationException::class);
        $this->verify(self::SECRET, self::BODY, $headers);
    }

    public function test_changed_timestamp_fails_verification(): void
    {
        $timestamp = time();
        $headers = (new WebhookSigner(self::SECRET))->headers(self::BODY, null, $timestamp);
        $headers[WebhookVerifier::HEADER_TIMESTAMP] = (string) ($timestamp - 1);

        $this->expectException(WebhookVerificationException::class);
        $this->verify(self::SECRET, self::BODY, $headers);
    }

    public function test_changed_secret_fails_verification(): void
    {
        $headers = (new WebhookSigner(self::SECRET))->headers(self::BODY);

        $this->expectException(WebhookVerificationException::class);
        $this->verify(self::OTHER_SECRET, self::BODY, $headers);
    }

    // ─── official test vector ────────────────────────────────────────────

    /**
     * Source: standard-webhooks/standard-webhooks, libraries/php/tests/WebhookTest.php,
     * testSignFunctionWorks (commit 59104160f10908d80ee571a81460e1c9c0c05355).
     */
    public function test_sign_matches_standard_webhooks_test_vector(): void
    {
        $signer = new WebhookSigner('whsec_MfKQ9r8GKYqrTwjUPD8ILPZIo2LaLaSw');

        $this->assertSame(
            'v1,g0hM9SsE+OTPJTGt/tmIKtSyZlE3uFJELVlNIOLJ1OE=',
            $signer->sign('msg_p5jXN8AQM9LWM0D4loKWxJek', 1614265330, '{"test": 2432232314}'),
        );
    }

    // ─── headers ─────────────────────────────────────────────────────────

    public function test_headers_use_given_msg_id_and_timestamp(): void
    {
        $signer = new WebhookSigner(self::SECRET);

        $this->assertSame([
            'webhook-id' => 'msg-given',
            'webhook-signature' => $signer->sign('msg-given', 1614265330, self::BODY),
            'webhook-timestamp' => '1614265330',
        ], $signer->headers(self::BODY, 'msg-given', 1614265330));
    }

    public function test_headers_generate_msg_id_and_current_timestamp(): void
    {
        $signer = new WebhookSigner(self::SECRET);

        $before = time();
        $headers = $signer->headers(self::BODY);
        $after = time();

        $this->assertMatchesRegularExpression(
            '/^msg-[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/',
            $headers[WebhookVerifier::HEADER_ID],
        );
        $this->assertNotSame($headers[WebhookVerifier::HEADER_ID], $signer->headers(self::BODY)[WebhookVerifier::HEADER_ID]);
        $this->assertGreaterThanOrEqual($before, (int) $headers[WebhookVerifier::HEADER_TIMESTAMP]);
        $this->assertLessThanOrEqual($after, (int) $headers[WebhookVerifier::HEADER_TIMESTAMP]);
    }

    // ─── invalid secret ──────────────────────────────────────────────────

    #[DataProvider('invalidSecretProvider')]
    public function test_invalid_secret_is_rejected(string $secret): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new WebhookSigner($secret);
    }

    /** @return array<string,array{string}> */
    public static function invalidSecretProvider(): array
    {
        return [
            'empty' => [''],
            'prefix only' => ['whsec_'],
            'invalid base64' => ['not-valid-base64!!!'],
        ];
    }

    // ─── secret protection ───────────────────────────────────────────────

    public function test_debug_info_is_empty(): void
    {
        $this->assertSame([], (new WebhookSigner(self::SECRET))->__debugInfo());
        $this->assertStringNotContainsString(self::SECRET, print_r(new WebhookSigner(self::SECRET), true));
    }

    public function test_serialization_is_rejected(): void
    {
        $this->expectException(\LogicException::class);
        serialize(new WebhookSigner(self::SECRET));
    }

    public function test_unserialization_is_rejected(): void
    {
        $this->expectException(\LogicException::class);
        unserialize('O:'.strlen(WebhookSigner::class).':"'.WebhookSigner::class.'":0:{}');
    }

    // ─── helpers ─────────────────────────────────────────────────────────

    /**
     * @param  array<string,string>  $headers
     */
    private function verify(string $secret, string $body, array $headers): void
    {
        (new WebhookVerifier($secret))->verify(
            $body,
            $headers[WebhookVerifier::HEADER_ID],
            $headers[WebhookVerifier::HEADER_SIGNATURE],
            $headers[WebhookVerifier::HEADER_TIMESTAMP],
        );
    }
}
