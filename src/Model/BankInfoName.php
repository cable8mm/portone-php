<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class BankInfoName
{
    public function __construct(public readonly string $ko) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(OperationResponse::requireString($data, 'ko', self::class));
    }
}
