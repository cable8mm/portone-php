<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class GetAllPaymentsByCursorResponse extends OperationResponse
{
    /** @param list<array<string,mixed>> $items */
    public function __construct(public readonly array $items) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        $items = $data['items'] ?? null;
        if (! is_array($items) || ! array_is_list($items) || array_filter($items, 'is_array') !== $items) {
            throw new \UnexpectedValueException('GetAllPaymentsByCursorResponse must contain a list of payment objects.');
        }

        return new self($items);
    }
}
