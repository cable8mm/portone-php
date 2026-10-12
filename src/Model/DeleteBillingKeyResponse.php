<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class DeleteBillingKeyResponse extends OperationResponse
{
    public function __construct(public readonly string $deletedAt) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_string($data['deletedAt'] ?? null)) {
            throw new \UnexpectedValueException('DeleteBillingKeyResponse must contain string deletedAt.');
        }

        return new self($data['deletedAt']);
    }
}
