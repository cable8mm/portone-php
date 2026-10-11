<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class GetPaymentsResponse
{
    /** @param list<Payment> $items @param array<string,mixed> $page */
    public function __construct(
        public readonly array $items,
        public readonly array $page,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): self
    {
        if (! isset($data['items'], $data['page']) || ! is_array($data['items']) || ! is_array($data['page'])) {
            throw new \UnexpectedValueException('GetPaymentsResponse must contain items and page arrays.');
        }

        if (array_filter($data['items'], 'is_array') !== $data['items']) {
            throw new \UnexpectedValueException('GetPaymentsResponse must contain payment objects.');
        }

        return new self(array_map(static fn (array $item): Payment => Payment::fromArray($item), $data['items']), $data['page']);
    }
}
