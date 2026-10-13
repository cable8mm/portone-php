<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 결제 사전 등록 성공 응답을 나타내는 모델입니다.
 */
final class PreRegisterPaymentResponse extends OperationResponse
{
    /**
     * PreRegisterPaymentResponse 객체를 초기화합니다.
     */
    public function __construct() {}

    /**
     * 배열 형식의 API 응답 데이터로 PreRegisterPaymentResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self;
    }
}
