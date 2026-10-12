<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class GetB2bTaxInvoicesResponse extends OperationResponse
{
    /**
     * @param  list<B2bTaxInvoice>  $items
     * @param  array<string, mixed>  $page
     */
    public function __construct(public readonly array $items, public readonly array $page) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        $items = $data['items'] ?? null;
        if (! is_array($items) || ! array_is_list($items) || array_filter($items, 'is_array') !== $items || ! is_array($data['page'] ?? null)) {
            throw new \UnexpectedValueException('GetB2bTaxInvoicesResponse must contain items and page arrays.');
        }

        return new self(array_map(static fn (array $item): B2bTaxInvoice => B2bTaxInvoice::fromArray($item), $items), $data['page']);
    }
}
