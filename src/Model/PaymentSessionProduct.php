<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class PaymentSessionProduct
{
    public function __construct(
        public readonly string $name,
        public readonly int $unitPrice,
        public readonly int $quantity,
        public readonly ?string $id,
        public readonly ?string $code,
        public readonly ?string $startDate,
        public readonly ?string $endDate,
        public readonly ?string $url,
        public readonly ?string $nPayCategoryType,
        public readonly ?string $nPayCategoryId,
        public readonly ?string $nPayUid,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            OperationResponse::requireString($data, 'name', self::class),
            OperationResponse::requireInt($data, 'unitPrice', self::class),
            OperationResponse::requireInt($data, 'quantity', self::class),
            OperationResponse::optionalNonNullableString($data, 'id', self::class),
            OperationResponse::optionalNonNullableString($data, 'code', self::class),
            OperationResponse::optionalNonNullableString($data, 'startDate', self::class),
            OperationResponse::optionalNonNullableString($data, 'endDate', self::class),
            OperationResponse::optionalNonNullableString($data, 'url', self::class),
            OperationResponse::optionalNonNullableString($data, 'nPayCategoryType', self::class),
            OperationResponse::optionalNonNullableString($data, 'nPayCategoryId', self::class),
            OperationResponse::optionalNonNullableString($data, 'nPayUid', self::class),
        );
    }
}
