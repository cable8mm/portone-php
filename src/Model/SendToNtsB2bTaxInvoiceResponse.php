<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class SendToNtsB2bTaxInvoiceResponse extends OperationResponse
{
    public function __construct(public readonly array $taxInvoice) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['taxInvoice'] ?? null)) {
            throw new \UnexpectedValueException('SendToNtsB2bTaxInvoiceResponse must contain a taxInvoice object.');
        }

        return new self($data['taxInvoice']);
    }
}
