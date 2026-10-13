<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 결제 건을 나타내는 모델입니다.
 */
final class Payment extends DiscriminatedResponse
{
    /** 응답에 포함된 디코딩된 결제 수단입니다. 없으면 null입니다. */
    public readonly ?PaymentMethod $method;

    /**
     * Payment 객체를 초기화합니다.
     *
     * @param  array<string,mixed>  $data
     */
    public function __construct(array $data, string $variant, bool $knownVariant)
    {
        parent::__construct($data, $variant, $knownVariant);

        $methodData = self::optionalObject($data, 'method', self::class);
        $this->method = $methodData !== null ? PaymentMethod::fromArray($methodData) : null;
    }

    /**
     * 배열 형식의 API 응답 데이터로 Payment 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'status', [
            'CANCELLED', 'FAILED', 'PAID', 'PARTIAL_CANCELLED', 'PAY_PENDING', 'READY', 'VIRTUAL_ACCOUNT_ISSUED',
        ]);

        if ($known) {
            self::requireFields($data, match ($variant) {
                'CANCELLED' => ['status', 'id', 'transactionId', 'merchantId', 'storeId', 'channel', 'version', 'requestedAt', 'updatedAt', 'statusChangedAt', 'orderName', 'amount', 'currency', 'customer', 'origin', 'cancellations', 'cancelledAt'],
                'FAILED' => ['status', 'id', 'transactionId', 'merchantId', 'storeId', 'version', 'requestedAt', 'updatedAt', 'statusChangedAt', 'orderName', 'amount', 'currency', 'customer', 'origin', 'failedAt', 'failure'],
                'PAID' => ['status', 'id', 'transactionId', 'merchantId', 'storeId', 'channel', 'version', 'requestedAt', 'updatedAt', 'statusChangedAt', 'orderName', 'amount', 'currency', 'customer', 'origin', 'paidAt', 'disputes'],
                'PARTIAL_CANCELLED' => ['status', 'id', 'transactionId', 'merchantId', 'storeId', 'channel', 'version', 'requestedAt', 'updatedAt', 'statusChangedAt', 'orderName', 'amount', 'currency', 'customer', 'origin', 'cancellations', 'cancelledAt'],
                default => ['status', 'id', 'transactionId', 'merchantId', 'storeId', 'channel', 'version', 'requestedAt', 'updatedAt', 'statusChangedAt', 'orderName', 'amount', 'currency', 'customer', 'origin'],
            });
        }

        return new self($data, $variant, $known);
    }
}
