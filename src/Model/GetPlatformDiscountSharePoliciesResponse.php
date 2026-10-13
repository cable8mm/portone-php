<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 할인 분담 정책 다건 조회 성공 응답 정보를 나타내는 모델입니다.
 */
final class GetPlatformDiscountSharePoliciesResponse extends OperationResponse
{
    /**
     * GetPlatformDiscountSharePoliciesResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly array $items, public readonly array $page) {}

    /**
     * 배열 형식의 API 응답 데이터로 GetPlatformDiscountSharePoliciesResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireObjectList($data, 'items', self::class),
            self::requireObject($data, 'page', self::class),
        );
    }
}
