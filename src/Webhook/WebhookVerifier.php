<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Webhook;

use Cable8mm\PortonePhp\Exception\WebhookVerificationException;

/**
 * PortOne 웹훅 서명을 검증하고 본문을 알맞은 웹훅 타입으로 변환합니다.
 */
final class WebhookVerifier
{
    public const HEADER_ID = 'webhook-id';

    public const HEADER_SIGNATURE = 'webhook-signature';

    public const HEADER_TIMESTAMP = 'webhook-timestamp';

    private const TOLERANCE_IN_SECONDS = 300;

    private readonly \Closure $secretProvider;

    /**
     * 웹훅 서명 검증에 사용할 webhookSecret으로 검증기를 초기화합니다.
     */
    public function __construct(#[\SensitiveParameter] string $webhookSecret)
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

        $this->secretProvider = static fn (): string => $secret;
    }

    /**
     * 인증 정보가 디버그 출력에 노출되지 않도록 빈 정보를 반환합니다.
     */
    public function __debugInfo(): array
    {
        return [];
    }

    /**
     * 인증 정보가 직렬화되어 노출되지 않도록 직렬화를 거부합니다.
     */
    public function __serialize(): array
    {
        throw new \LogicException('WebhookVerifier instances cannot be serialized.');
    }

    /**
     * 인증 정보가 포함된 객체의 역직렬화를 거부합니다.
     */
    public function __unserialize(#[\SensitiveParameter] array $data): void
    {
        throw new \LogicException('WebhookVerifier instances cannot be unserialized.');
    }

    /**
     * 웹훅 서명과 타임스탬프를 검증한 뒤 알려진 유형은 타입 객체로, 알 수 없는 유형은 UnrecognizedWebhook으로 반환합니다.
     */
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

        $expected = hash_hmac('sha256', $msgId.'.'.$timestamp.'.'.$body, ($this->secretProvider)(), true);
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

        $type = $decoded['type'] ?? null;

        if (is_string($type) && str_starts_with($type, 'Transaction.')) {
            try {
                return WebhookTransaction::fromArray($decoded);
            } catch (\Throwable $exception) {
                throw new WebhookVerificationException('Known webhook body is invalid.', previous: $exception);
            }
        }

        if (is_string($type) && str_starts_with($type, 'BillingKey.')) {
            try {
                return WebhookBillingKey::fromArray($decoded);
            } catch (\Throwable $exception) {
                throw new WebhookVerificationException('Known webhook body is invalid.', previous: $exception);
            }
        }

        return new UnrecognizedWebhook($decoded);
    }
}
