<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class CashReceipt extends DiscriminatedResponse
{
    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'status', ['CANCELLED', 'ISSUED', 'ISSUE_FAILED']);

        if ($known) {
            self::requireFields($data, match ($variant) {
                'CANCELLED' => ['status', 'merchantId', 'storeId', 'paymentId', 'channel', 'amount', 'currency', 'orderName', 'isManual', 'issueNumber', 'issuedAt', 'cancelledAt'],
                'ISSUE_FAILED' => ['status', 'merchantId', 'storeId', 'paymentId', 'orderName', 'isManual'],
                default => ['status', 'merchantId', 'storeId', 'paymentId', 'channel', 'amount', 'currency', 'orderName', 'isManual', 'issueNumber', 'issuedAt'],
            });
        }

        return new self($data, $variant, $known);
    }
}
