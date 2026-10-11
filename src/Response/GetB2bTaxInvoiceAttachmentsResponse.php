<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class GetB2bTaxInvoiceAttachmentsResponse extends OperationResponse
{
    /** @param list<array<string,mixed>> $attachments */
    public function __construct(public readonly array $attachments) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        $attachments = $data['attachments'] ?? null;
        if (! is_array($attachments) || ! array_is_list($attachments) || array_filter($attachments, 'is_array') !== $attachments) {
            throw new \UnexpectedValueException('GetB2bTaxInvoiceAttachmentsResponse must contain a list of attachment objects.');
        }

        return new self($attachments);
    }
}
