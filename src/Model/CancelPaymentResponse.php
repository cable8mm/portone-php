<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class CancelPaymentResponse extends OperationResponse
{
    public function __construct(public readonly PaymentCancellation $cancellation) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(PaymentCancellation::fromArray(self::requireObject($data, 'cancellation', self::class)));
    }
}
