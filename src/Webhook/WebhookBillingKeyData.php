<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Webhook;

/**
 * BillingKey.* 이벤트에 공통으로 포함되는 데이터를 나타냅니다.
 */
final class WebhookBillingKeyData
{
    /**
     * WebhookBillingKeyData 객체를 초기화합니다.
     */
    public function __construct(
        public readonly string $billingKey,
        public readonly string $storeId,
    ) {}

    /**
     * 배열 형식의 API 응답 데이터로 WebhookBillingKeyData 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (string) ($data['billingKey'] ?? ''),
            (string) ($data['storeId'] ?? ''),
        );
    }
}
