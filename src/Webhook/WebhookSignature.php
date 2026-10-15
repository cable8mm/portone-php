<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Webhook;

/**
 * WebhookVerifier와 WebhookSigner가 함께 쓰는 webhookSecret 해석 규칙과 서명 계산 규칙입니다.
 *
 * @internal
 */
final class WebhookSignature
{
    private const SECRET_PREFIX = 'whsec_';

    private function __construct() {}

    /**
     * webhookSecret에서 whsec_ 접두사를 떼고 Base64로 디코딩한 서명 키를 반환합니다.
     *
     * @throws \InvalidArgumentException webhookSecret이 비어 있거나 올바른 Base64 값이 아닐 때 발생합니다.
     */
    public static function decodeSecret(#[\SensitiveParameter] string $webhookSecret): string
    {
        if ($webhookSecret === '') {
            throw new \InvalidArgumentException('webhookSecret must not be empty.');
        }

        $encoded = str_starts_with($webhookSecret, self::SECRET_PREFIX)
            ? substr($webhookSecret, strlen(self::SECRET_PREFIX))
            : $webhookSecret;
        $secret = base64_decode($encoded, true);
        if ($secret === false || $secret === '') {
            throw new \InvalidArgumentException('webhookSecret must be a valid non-empty Base64 value.');
        }

        return $secret;
    }

    /**
     * {msgId}.{timestamp}.{body}에 대한 HMAC-SHA256 원시 서명 바이트를 계산합니다.
     */
    public static function compute(#[\SensitiveParameter] string $secret, string $msgId, int $timestamp, string $body): string
    {
        return hash_hmac('sha256', $msgId.'.'.$timestamp.'.'.$body, $secret, true);
    }
}
