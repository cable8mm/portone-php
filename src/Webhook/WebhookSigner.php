<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Webhook;

/**
 * 테스트와 로컬 확인용으로 웹훅에 Standard Webhooks 서명을 만듭니다.
 *
 * 서명 규칙은 WebhookVerifier와 같으므로 이 서명기가 만든 헤더는 WebhookVerifier::verify()를 통과합니다.
 */
final class WebhookSigner
{
    private readonly \Closure $secretProvider;

    /**
     * WebhookVerifier와 같은 webhookSecret으로 서명기를 초기화합니다.
     */
    public function __construct(#[\SensitiveParameter] string $webhookSecret)
    {
        $secret = WebhookSignature::decodeSecret($webhookSecret);

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
        throw new \LogicException('WebhookSigner instances cannot be serialized.');
    }

    /**
     * 인증 정보가 포함된 객체의 역직렬화를 거부합니다.
     */
    public function __unserialize(#[\SensitiveParameter] array $data): void
    {
        throw new \LogicException('WebhookSigner instances cannot be unserialized.');
    }

    /**
     * webhook-signature 헤더 값을 반환합니다.
     *
     * @param  string  $msgId  webhook-id 헤더 값입니다.
     * @param  int  $timestamp  webhook-timestamp 헤더 값(Unix 초)입니다.
     * @param  string  $body  서명할 원본 요청 본문입니다.
     * @return string `v1,<Base64 서명>` 형식의 값입니다.
     */
    public function sign(string $msgId, int $timestamp, string $body): string
    {
        return 'v1,'.base64_encode(WebhookSignature::compute(($this->secretProvider)(), $msgId, $timestamp, $body));
    }

    /**
     * webhook-id, webhook-signature, webhook-timestamp 헤더를 반환합니다.
     *
     * @param  string  $body  서명할 원본 요청 본문입니다.
     * @param  string|null  $msgId  webhook-id 값입니다. 없으면 `msg-` 뒤에 무작위 UUID를 붙여 만듭니다.
     * @param  int|null  $timestamp  webhook-timestamp 값입니다. 없으면 현재 시각을 씁니다.
     * @return array<string,string>
     */
    public function headers(string $body, ?string $msgId = null, ?int $timestamp = null): array
    {
        $msgId ??= 'msg-'.self::uuid();
        $timestamp ??= time();

        return [
            WebhookVerifier::HEADER_ID => $msgId,
            WebhookVerifier::HEADER_SIGNATURE => $this->sign($msgId, $timestamp, $body),
            WebhookVerifier::HEADER_TIMESTAMP => (string) $timestamp,
        ];
    }

    /**
     * 무작위 UUID(버전 4)를 만듭니다.
     */
    private static function uuid(): string
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr((ord($bytes[6]) & 0x0F) | 0x40);
        $bytes[8] = chr((ord($bytes[8]) & 0x3F) | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }
}
