<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class GetIdentityVerificationsResponse extends OperationResponse
{
    /** @param list<IdentityVerification> $items */
    public function __construct(public readonly array $items, public readonly array $page) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(self::mapObjectList(self::requireObjectList($data, 'items', self::class), static fn (array $item): IdentityVerification => IdentityVerification::fromArray($item)), self::requireObject($data, 'page', self::class));
    }
}
