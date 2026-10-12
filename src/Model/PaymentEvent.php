<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class PaymentEvent extends DiscriminatedResponse
{
    /** @param array<string,mixed> $data */
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
