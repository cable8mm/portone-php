<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class PaymentCancellation extends DiscriminatedResponse
{
    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'status', ['FAILED', 'REQUESTED', 'SUCCEEDED']);

        if ($known) {
            self::requireFields($data, [
                'status', 'id', 'totalAmount', 'taxFreeAmount', 'vatAmount', 'reason', 'requestedAt',
            ]);
        }

        return new self($data, $variant, $known);
    }
}
