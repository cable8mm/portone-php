<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class PlatformTransfer extends DiscriminatedResponse
{
    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'type', ['MANUAL', 'ORDER', 'ORDER_CANCEL']);

        if ($known) {
            self::requireFields($data, ['type', 'id', 'graphqlId', 'partner', 'status', 'settlementDate', 'settlementCurrency', 'isForTest', 'userDefinedProperties']);
        }

        return new self($data, $variant, $known);
    }
}
