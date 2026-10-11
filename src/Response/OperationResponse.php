<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

class OperationResponse
{
    /** @param array<string,mixed> $data */
    public function __construct(public readonly array $data) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
