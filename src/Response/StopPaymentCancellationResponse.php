<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class StopPaymentCancellationResponse extends OperationResponse
{
    public function __construct(public readonly string $stoppedAt) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_string($data['stoppedAt'] ?? null)) {
            throw new \UnexpectedValueException('StopPaymentCancellationResponse must contain string stoppedAt.');
        }

        return new self($data['stoppedAt']);
    }
}
