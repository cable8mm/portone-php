<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class PaymentWithCursor
{
    public function __construct(public readonly Payment $payment, public readonly string $cursor) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            Payment::fromArray(OperationResponse::requireObject($data, 'payment', self::class)),
            OperationResponse::requireString($data, 'cursor', self::class),
        );
    }
}
