<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class CancelPaymentResponse extends OperationResponse
{
    /** @param array<string,mixed> $cancellation */
    public function __construct(public readonly array $cancellation) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['cancellation'] ?? null)) {
            throw new \UnexpectedValueException('CancelPaymentResponse must contain a cancellation object.');
        }

        return new self($data['cancellation']);
    }
}
