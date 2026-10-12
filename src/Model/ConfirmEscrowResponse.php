<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class ConfirmEscrowResponse extends OperationResponse
{
    public function __construct(public readonly string $completedAt) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_string($data['completedAt'] ?? null)) {
            throw new \UnexpectedValueException('ConfirmEscrowResponse must contain string completedAt.');
        }

        return new self($data['completedAt']);
    }
}
