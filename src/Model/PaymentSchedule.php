<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 결제 예약 건을 나타내는 모델입니다.
 */
final class PaymentSchedule extends DiscriminatedResponse
{
    /**
     * 배열 형식의 API 응답 데이터로 PaymentSchedule 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'status', [
            'FAILED', 'PENDING', 'REVOKED', 'SCHEDULED', 'STARTED', 'SUCCEEDED',
        ]);

        if ($known) {
            self::requireFields($data, match ($variant) {
                'REVOKED' => ['status', 'id', 'merchantId', 'storeId', 'paymentId', 'billingKey', 'orderName', 'isCulturalExpense', 'isEscrow', 'customer', 'customData', 'totalAmount', 'currency', 'createdAt', 'timeToPay', 'revokedAt'],
                'SCHEDULED' => ['status', 'id', 'merchantId', 'storeId', 'paymentId', 'billingKey', 'orderName', 'isCulturalExpense', 'isEscrow', 'customer', 'customData', 'totalAmount', 'currency', 'createdAt', 'timeToPay'],
                'STARTED' => ['status', 'id', 'merchantId', 'storeId', 'paymentId', 'billingKey', 'orderName', 'isCulturalExpense', 'isEscrow', 'customer', 'customData', 'totalAmount', 'currency', 'createdAt', 'timeToPay', 'startedAt'],
                default => ['status', 'id', 'merchantId', 'storeId', 'paymentId', 'billingKey', 'orderName', 'isCulturalExpense', 'isEscrow', 'customer', 'customData', 'totalAmount', 'currency', 'createdAt', 'timeToPay', 'startedAt', 'completedAt'],
            });
        }

        return new self($data, $variant, $known);
    }
}
