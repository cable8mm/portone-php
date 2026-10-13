<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 카카오페이 주문 조회 응답을 나타내는 모델입니다.
 */
final class GetKakaopayPaymentOrderResponse extends OperationResponse
{
    /**
     * GetKakaopayPaymentOrderResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly int $statusCode, public readonly string $body) {}

    /**
     * 배열 형식의 API 응답 데이터로 GetKakaopayPaymentOrderResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        if (! is_int($data['statusCode'] ?? null) || ! is_string($data['body'] ?? null)) {
            throw new \UnexpectedValueException('GetKakaopayPaymentOrderResponse contains invalid fields.');
        }

        return new self($data['statusCode'], $data['body']);
    }
}
