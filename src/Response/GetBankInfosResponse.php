<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class GetBankInfosResponse extends OperationResponse
{
    /** @param list<BankInfo> $items */
    public function __construct(public readonly array $items) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(self::mapObjectList(
            self::requireObjectList($data, 'items', self::class),
            static fn (array $item): BankInfo => BankInfo::fromArray($item),
        ));
    }
}
