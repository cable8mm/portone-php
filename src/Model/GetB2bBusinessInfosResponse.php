<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class GetB2bBusinessInfosResponse extends OperationResponse
{
    /** @param list<array<string,mixed>> $result */
    public function __construct(public readonly array $result) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        $result = $data['result'] ?? null;
        if (! is_array($result) || ! array_is_list($result) || array_filter($result, 'is_array') !== $result) {
            throw new \UnexpectedValueException('GetB2bBusinessInfosResponse must contain a list of result objects.');
        }

        return new self($result);
    }
}
