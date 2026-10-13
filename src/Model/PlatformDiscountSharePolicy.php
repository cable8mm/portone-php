<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 할인 분담 정책을 나타내는 모델입니다.
 */
final class PlatformDiscountSharePolicy extends OperationResponse
{
    /**
     * PlatformDiscountSharePolicy 객체를 초기화합니다.
     */
    public function __construct(
        public readonly string $id,
        public readonly string $graphqlId,
        public readonly string $name,
        public readonly int $partnerShareRate,
        public readonly ?string $memo,
        public readonly bool $isArchived,
        public readonly string $appliedAt,
        public readonly bool $isForTest,
    ) {}

    /**
     * 배열 형식의 API 응답 데이터로 PlatformDiscountSharePolicy 객체를 생성합니다.
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
            self::requireInt($data, 'partnerShareRate', self::class),
            self::optionalNonNullableString($data, 'memo', self::class),
            self::requireBool($data, 'isArchived', self::class),
            self::requireString($data, 'appliedAt', self::class),
            self::requireBool($data, 'isForTest', self::class),
        );
    }
}
