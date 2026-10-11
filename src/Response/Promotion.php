<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class Promotion extends DiscriminatedResponse
{
    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'type', ['CARD']);

        if ($known) {
            self::requireFields($data, ['type', 'id', 'storeId', 'name', 'discountPolicy', 'totalBudget', 'spentAmount', 'currency', 'startAt', 'endAt', 'cardCompany', 'status', 'createdAt', 'recoverOption']);
        }

        return new self($data, $variant, $known);
    }
}
