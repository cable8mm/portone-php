<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 결제 이벤트를 나타내는 모델입니다.
 */
final class PaymentEvent extends DiscriminatedResponse
{
    /**
     * 배열 형식의 API 응답 데이터로 PaymentEvent 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'type', ['CANCELLED', 'PAID', 'PARTIAL_CANCELLED']);

        if ($known) {
            self::requireFields($data, match ($variant) {
                'PAID' => ['type', 'id', 'paymentId', 'transactionId', 'merchantId', 'storeId', 'channel', 'version', 'requestedAt', 'createdAt', 'orderName', 'totalAmount', 'currency', 'customer', 'disputes', 'eventAmount', 'origin'],
                default => ['type', 'id', 'paymentId', 'transactionId', 'merchantId', 'storeId', 'channel', 'version', 'requestedAt', 'createdAt', 'orderName', 'totalAmount', 'currency', 'customer', 'eventAmount', 'origin'],
            });
        }

        return new self($data, $variant, $known);
    }
}
