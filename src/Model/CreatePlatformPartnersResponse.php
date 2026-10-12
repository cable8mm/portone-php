<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class CreatePlatformPartnersResponse extends OperationResponse
{
    /** @param list<array<string,mixed>> $partners */
    public function __construct(public readonly array $partners) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(self::requireObjectList($data, 'partners', self::class));
    }
}
