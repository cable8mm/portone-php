<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class CancelCashReceiptResponse extends OperationResponse
{
    public function __construct(public readonly int $cancelledAmount, public readonly string $cancelledAt) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_int($data['cancelledAmount'] ?? null) || ! is_string($data['cancelledAt'] ?? null)) {
            throw new \UnexpectedValueException('CancelCashReceiptResponse contains invalid fields.');
        }

        return new self($data['cancelledAmount'], $data['cancelledAt']);
    }
}
