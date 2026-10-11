<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class UpdateB2bTaxInvoiceDraftResponse extends OperationResponse
{
    public function __construct(public readonly array $taxInvoice) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['taxInvoice'] ?? null)) {
            throw new \UnexpectedValueException('UpdateB2bTaxInvoiceDraftResponse must contain a taxInvoice object.');
        }

        return new self($data['taxInvoice']);
    }
}
