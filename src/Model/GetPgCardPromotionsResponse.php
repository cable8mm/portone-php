<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class GetPgCardPromotionsResponse extends OperationResponse
{
    /** @param list<array<string,mixed>>|null $promotions */
    public function __construct(public readonly ?array $promotions) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(self::optionalObjectList($data, 'promotions', self::class));
    }
}
