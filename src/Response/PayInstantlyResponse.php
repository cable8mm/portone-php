<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class PayInstantlyResponse extends OperationResponse
{
    /** @param array<string,mixed> $payment */
    public function __construct(public readonly array $payment) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['payment'] ?? null)) {
            throw new \UnexpectedValueException('PayInstantlyResponse must contain a payment object.');
        }

        return new self($data['payment']);
    }
}
