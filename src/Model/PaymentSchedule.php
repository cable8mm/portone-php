<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class PaymentSchedule extends DiscriminatedResponse
{
    /** @param array<string,mixed> $data */
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
