<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class B2bBulkTaxInvoice extends OperationResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $graphqlId,
        public readonly ?string $name,
        public readonly string $status,
        public readonly int $totalInvoiceCount,
        public readonly int $totalAmount,
        public readonly array $stats,
        public readonly string $createdAt,
        public readonly ?string $scheduledAt,
        public readonly ?string $requestedAt,
        public readonly string $statusUpdatedAt,
        public readonly string $sourceType,
        public readonly string $issuanceType,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'id', self::class),
            self::requireString($data, 'graphqlId', self::class),
            self::optionalNonNullableString($data, 'name', self::class),
            self::requireString($data, 'status', self::class),
            self::requireInt($data, 'totalInvoiceCount', self::class),
            self::requireInt($data, 'totalAmount', self::class),
            self::requireObject($data, 'stats', self::class),
            self::requireString($data, 'createdAt', self::class),
            self::optionalNonNullableString($data, 'scheduledAt', self::class),
            self::optionalNonNullableString($data, 'requestedAt', self::class),
            self::requireString($data, 'statusUpdatedAt', self::class),
            self::requireString($data, 'sourceType', self::class),
            self::requireString($data, 'issuanceType', self::class),
        );
    }
}
