<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class ConfirmedBillingKeySummary extends OperationResponse
{
    public function __construct(public readonly string $billingKey) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(self::requireString($data, 'billingKey', self::class));
    }
}
