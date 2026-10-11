<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class CloseVirtualAccountResponse extends OperationResponse
{
    public function __construct(public readonly string $closedAt) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_string($data['closedAt'] ?? null)) {
            throw new \UnexpectedValueException('CloseVirtualAccountResponse must contain string closedAt.');
        }

        return new self($data['closedAt']);
    }
}
