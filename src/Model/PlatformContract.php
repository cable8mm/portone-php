<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class PlatformContract extends OperationResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $graphqlId,
        public readonly string $name,
        public readonly ?string $memo,
        public readonly array $platformFee,
        public readonly string $settlementCycle,
        public readonly string $platformFeeVatPayer,
        public readonly bool $subtractPaymentVatAmount,
        public readonly bool $isArchived,
        public readonly string $appliedAt,
        public readonly bool $isForTest,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'id', self::class),
            self::requireString($data, 'graphqlId', self::class),
            self::requireString($data, 'name', self::class),
            self::optionalNonNullableString($data, 'memo', self::class),
            self::requireObject($data, 'platformFee', self::class),
            self::requireString($data, 'settlementCycle', self::class),
            self::requireString($data, 'platformFeeVatPayer', self::class),
            self::requireBool($data, 'subtractPaymentVatAmount', self::class),
            self::requireBool($data, 'isArchived', self::class),
            self::requireString($data, 'appliedAt', self::class),
            self::requireBool($data, 'isForTest', self::class),
        );
    }
}
