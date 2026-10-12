<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Webhook;

use Cable8mm\PortonePhp\Exception\WebhookVerificationException;

final class WebhookVerifier
{
    public const HEADER_ID = 'webhook-id';

    public const HEADER_SIGNATURE = 'webhook-signature';

    public const HEADER_TIMESTAMP = 'webhook-timestamp';

    private const TOLERANCE_IN_SECONDS = 300;

    private readonly string $secret;

    public function __construct(string $webhookSecret)
    {
        if ($webhookSecret === '') {
            throw new \InvalidArgumentException('webhookSecret must not be empty.');
        }

        $encoded = str_starts_with($webhookSecret, 'whsec_')
            ? substr($webhookSecret, 6)
            : $webhookSecret;
        $secret = base64_decode($encoded, true);
        if ($secret === false || $secret === '') {
            throw new \InvalidArgumentException('webhookSecret must be a valid non-empty Base64 value.');
        }

        $this->secret = $secret;
    }

    public function verify(string $body, ?string $msgId, ?string $msgSignature, ?string $msgTimestamp): Webhook
    {
        if ($msgId === null || $msgSignature === null || $msgTimestamp === null) {
            throw new WebhookVerificationException('Missing required headers.');
        }

        $timestamp = filter_var($msgTimestamp, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
        if ($timestamp === false) {
            throw new WebhookVerificationException('Invalid Signature Headers.');
        }

        $now = time();
        if ($timestamp < $now - self::TOLERANCE_IN_SECONDS) {
            throw new WebhookVerificationException('Message timestamp too old.');
        }
        if ($timestamp > $now + self::TOLERANCE_IN_SECONDS) {
            throw new WebhookVerificationException('Message timestamp too new.');
        }

        $expected = hash_hmac('sha256', $msgId.'.'.$timestamp.'.'.$body, $this->secret, true);
        $matched = false;
        foreach (explode(' ', $msgSignature) as $versionedSignature) {
            $parts = explode(',', $versionedSignature, 3);
            if (count($parts) < 2 || $parts[0] !== 'v1') {
                continue;
            }

            $signature = base64_decode($parts[1], true);
            if ($signature !== false && hash_equals($expected, $signature)) {
                $matched = true;
                break;
            }
        }
        if (! $matched) {
            throw new WebhookVerificationException('No matching signature found.');
        }

        try {
            $decoded = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
            if (! is_array($decoded)) {
                throw new \UnexpectedValueException('Webhook body must be a JSON object.');
            }
        } catch (\Throwable $exception) {
            throw new WebhookVerificationException('Webhook body could not be decoded.', previous: $exception);
        }

        if (($decoded['type'] ?? null) === 'Transaction.Paid') {
            try {
                return WebhookTransactionPaid::fromArray($decoded);
            } catch (\Throwable $exception) {
                throw new WebhookVerificationException('Known webhook body is invalid.', previous: $exception);
            }
        }

        return new UnrecognizedWebhook($decoded);
    }
}
