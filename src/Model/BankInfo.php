<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class BankInfo
{
    public function __construct(public readonly string $bank, public readonly BankInfoName $name) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            OperationResponse::requireString($data, 'bank', self::class),
            BankInfoName::fromArray(OperationResponse::requireObject($data, 'name', self::class)),
        );
    }
}
