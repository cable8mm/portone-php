<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 결제 세션 약관을 나타내는 모델입니다.
 */
final class PaymentSessionAgreement
{
    /**
     * PaymentSessionAgreement 객체를 초기화합니다.
     */
    public function __construct(public readonly string $name, public readonly string $url) {}

    /**
     * 배열 형식의 API 응답 데이터로 PaymentSessionAgreement 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            OperationResponse::requireString($data, 'name', self::class),
            OperationResponse::requireString($data, 'url', self::class),
        );
    }
}
