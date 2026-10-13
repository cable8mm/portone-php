<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 수기 결제 성공 응답을 나타내는 모델입니다.
 */
final class PayInstantlyResponse extends OperationResponse
{
    /**
     * PayInstantlyResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly InstantPaymentSummary $payment) {}

    /**
     * 배열 형식의 API 응답 데이터로 PayInstantlyResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self(InstantPaymentSummary::fromArray(self::requireObject($data, 'payment', self::class)));
    }
}
