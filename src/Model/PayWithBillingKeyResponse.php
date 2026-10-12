<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class PayWithBillingKeyResponse extends OperationResponse
{
    public function __construct(public readonly BillingKeyPaymentSummary $payment) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(BillingKeyPaymentSummary::fromArray(self::requireObject($data, 'payment', self::class)));
    }
}
