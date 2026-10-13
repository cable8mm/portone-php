<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 추가 수수료 정책 업데이트 예약 성공 응답을 나타내는 모델입니다.
 */
final class SchedulePlatformAdditionalFeePolicyResponse extends OperationResponse
{
    /**
     * SchedulePlatformAdditionalFeePolicyResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly array $scheduledAdditionalFeePolicy) {}

    /**
     * 배열 형식의 API 응답 데이터로 SchedulePlatformAdditionalFeePolicyResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['scheduledAdditionalFeePolicy'] ?? null)) {
            throw new \UnexpectedValueException('SchedulePlatformAdditionalFeePolicyResponse must contain an object.');
        }

        return new self($data['scheduledAdditionalFeePolicy']);
    }
}
