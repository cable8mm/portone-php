<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class UpdateB2bCounterpartyResponse extends OperationResponse
{
    public function __construct(public readonly array $counterparty) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['counterparty'] ?? null)) {
            throw new \UnexpectedValueException('UpdateB2bCounterpartyResponse must contain a counterparty object.');
        }

        return new self($data['counterparty']);
    }
}
