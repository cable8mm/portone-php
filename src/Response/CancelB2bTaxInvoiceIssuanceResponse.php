<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class CancelB2bTaxInvoiceIssuanceResponse extends OperationResponse
{
    public function __construct(public readonly array $taxInvoice) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['taxInvoice'] ?? null)) {
            throw new \UnexpectedValueException('CancelB2bTaxInvoiceIssuanceResponse must contain a taxInvoice object.');
        }

        return new self($data['taxInvoice']);
    }
}
