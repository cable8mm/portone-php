<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class GetB2bTaxInvoicePrintUrlResponse extends OperationResponse
{
    public function __construct(public readonly string $url) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_string($data['url'] ?? null)) {
            throw new \UnexpectedValueException('GetB2bTaxInvoicePrintUrlResponse must contain string url.');
        }

        return new self($data['url']);
    }
}
