<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 파트너 업데이트 예약 성공 응답을 나타내는 모델입니다.
 */
final class SchedulePlatformPartnerResponse extends OperationResponse
{
    /**
     * SchedulePlatformPartnerResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly array $scheduledPartner) {}

    /**
     * 배열 형식의 API 응답 데이터로 SchedulePlatformPartnerResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['scheduledPartner'] ?? null)) {
            throw new \UnexpectedValueException('SchedulePlatformPartnerResponse must contain an object.');
        }

        return new self($data['scheduledPartner']);
    }
}
