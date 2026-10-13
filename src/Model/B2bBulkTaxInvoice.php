<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 B2bBulkTaxInvoice 데이터를 나타내는 모델입니다.
 */
final class B2bBulkTaxInvoice extends OperationResponse
{
    /**
     * B2bBulkTaxInvoice 객체를 초기화합니다.
     */
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

    /**
     * 배열 형식의 API 응답 데이터로 B2bBulkTaxInvoice 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
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
