<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 파트너 예약 업데이트 취소 성공 응답을 나타내는 모델입니다.
 */
final class CancelPlatformPartnerScheduleResponse extends OperationResponse
{
    /**
     * CancelPlatformPartnerScheduleResponse 객체를 초기화합니다.
     */
    public function __construct() {}

    /**
     * 배열 형식의 API 응답 데이터로 CancelPlatformPartnerScheduleResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self;
    }
}
