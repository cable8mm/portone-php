<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class RecoverPlatformContractResponse extends OperationResponse
{
    public function __construct(public readonly array $contract) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['contract'] ?? null)) {
            throw new \UnexpectedValueException('RecoverPlatformContractResponse must contain a contract object.');
        }

        return new self($data['contract']);
    }
}
