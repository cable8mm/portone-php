<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 파트너 필터 옵션 조회 성공 응답 정보를 나타내는 모델입니다.
 */
final class PlatformPartnerFilterOptions extends OperationResponse
{
    /**
     * PlatformPartnerFilterOptions 객체를 초기화합니다.
     *
     * @param  list<string>  $tags
     * @param  list<array<string, mixed>>  $contractSummary
     */
    public function __construct(public readonly array $tags, public readonly array $contractSummary) {}

    /**
     * 배열 형식의 API 응답 데이터로 PlatformPartnerFilterOptions 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireStringList($data, 'tags', self::class),
            self::requireObjectList($data, 'contractSummary', self::class),
        );
    }
}
