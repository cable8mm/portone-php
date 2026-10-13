<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Webhook;

/**
 * Transaction.* 이벤트에 공통으로 포함되는 데이터를 나타냅니다.
 */
final class WebhookTransactionData
{
    /**
     * WebhookTransactionData 객체를 초기화합니다.
     */
    public function __construct(
        public readonly string $paymentId,
        public readonly string $storeId,
        public readonly string $transactionId,
        public readonly ?string $cancellationId = null,
    ) {}

    /**
     * 배열 형식의 API 응답 데이터로 WebhookTransactionData 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (string) ($data['paymentId'] ?? ''),
            (string) ($data['storeId'] ?? ''),
            (string) ($data['transactionId'] ?? ''),
            isset($data['cancellationId']) ? (string) $data['cancellationId'] : null,
        );
    }
}
