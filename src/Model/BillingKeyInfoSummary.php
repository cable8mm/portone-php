<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class BillingKeyInfoSummary extends OperationResponse
{
    public function __construct(
        public readonly string $billingKey,
        public readonly string $issuedAt,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'billingKey', self::class),
            self::requireString($data, 'issuedAt', self::class),
        );
    }
}
