<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class RegisterStoreReceiptResponse extends OperationResponse
{
    public function __construct(public readonly ?string $receiptUrl) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (($data['receiptUrl'] ?? null) !== null && ! is_string($data['receiptUrl'])) {
            throw new \UnexpectedValueException('RegisterStoreReceiptResponse receiptUrl must be a string or null.');
        }

        return new self($data['receiptUrl'] ?? null);
    }
}
