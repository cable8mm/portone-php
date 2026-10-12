<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class BillingKeyPaymentSummary extends OperationResponse
{
    public function __construct(
        public readonly string $pgTxId,
        public readonly string $paidAt,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'pgTxId', self::class),
            self::requireString($data, 'paidAt', self::class),
        );
    }
}
