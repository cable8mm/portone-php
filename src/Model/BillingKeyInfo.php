<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class BillingKeyInfo extends DiscriminatedResponse
{
    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'status', ['DELETED', 'ISSUED']);

        if ($known) {
            self::requireFields($data, $variant === 'DELETED'
                ? ['status', 'billingKey', 'merchantId', 'storeId', 'channels', 'customer', 'issuedAt', 'deletedAt']
                : ['status', 'billingKey', 'merchantId', 'storeId', 'channels', 'customer', 'issuedAt']);
        }

        return new self($data, $variant, $known);
    }
}
