<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class ConfirmedBillingKeyIssueAndPaySummary extends OperationResponse
{
    public function __construct(public readonly string $billingKey, public readonly string $paymentId) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'billingKey', self::class),
            self::requireString($data, 'paymentId', self::class),
        );
    }
}
