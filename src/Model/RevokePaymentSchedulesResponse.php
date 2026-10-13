<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 결제 예약 건 취소 성공 응답을 나타내는 모델입니다.
 */
final class RevokePaymentSchedulesResponse extends OperationResponse
{
    /**
     * RevokePaymentSchedulesResponse 객체를 초기화합니다.
     *
     * @param  list<string>  $revokedScheduleIds
     */
    public function __construct(
        public readonly ?string $revokedAt,
        public readonly array $revokedScheduleIds,
    ) {}

    /**
     * 배열 형식의 API 응답 데이터로 RevokePaymentSchedulesResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self(
            self::optionalString($data, 'revokedAt', self::class),
            self::requireStringList($data, 'revokedScheduleIds', self::class),
        );
    }
}
