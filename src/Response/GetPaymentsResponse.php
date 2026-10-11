<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class GetPaymentsResponse
{
    /** @param list<array<string,mixed>> $items @param array<string,mixed> $page */
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

        return new self($data['items'], $data['page']);
    }
}
