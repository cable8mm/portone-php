<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class GetB2bCounterpartiesResponse extends OperationResponse
{
    /** @param list<array<string,mixed>> $items @param array<string,mixed> $page */
    public function __construct(public readonly array $items, public readonly array $page) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        $items = $data['items'] ?? null;
        if (! is_array($items) || ! array_is_list($items) || array_filter($items, 'is_array') !== $items || ! is_array($data['page'] ?? null)) {
            throw new \UnexpectedValueException('GetB2bCounterpartiesResponse must contain items and page arrays.');
        }

        return new self($items, $data['page']);
    }
}
