<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 계약을 나타내는 모델입니다.
 */
final class PlatformContract extends OperationResponse
{
    /**
     * PlatformContract 객체를 초기화합니다.
     *
     * @param  array<string,mixed>  $settlementCycle  정산 주기입니다.
     * @param  array<string,mixed>  $data  디코딩된 응답 본문입니다.
     */
    public function __construct(
        public readonly string $id,
        public readonly string $graphqlId,
        public readonly string $name,
        public readonly ?string $memo,
        public readonly array $platformFee,
        public readonly array $settlementCycle,
        public readonly string $platformFeeVatPayer,
        public readonly bool $subtractPaymentVatAmount,
        public readonly bool $isArchived,
        public readonly string $appliedAt,
        public readonly bool $isForTest,
        array $data = [],
    ) {
        parent::__construct($data);
    }

    /**
     * 배열 형식의 API 응답 데이터로 PlatformContract 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'id', self::class),
            self::requireString($data, 'graphqlId', self::class),
            self::requireString($data, 'name', self::class),
            self::optionalNonNullableString($data, 'memo', self::class),
            self::requireObject($data, 'platformFee', self::class),
            self::requireObject($data, 'settlementCycle', self::class),
            self::requireString($data, 'platformFeeVatPayer', self::class),
            self::requireBool($data, 'subtractPaymentVatAmount', self::class),
            self::requireBool($data, 'isArchived', self::class),
            self::requireString($data, 'appliedAt', self::class),
            self::requireBool($data, 'isForTest', self::class),
            data: $data,
        );
    }
}
