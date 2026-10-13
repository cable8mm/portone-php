<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 결제 건 및 커서 정보를 나타내는 모델입니다.
 */
final class PaymentWithCursor
{
    /**
     * PaymentWithCursor 객체를 초기화합니다.
     */
    public function __construct(public readonly Payment $payment, public readonly string $cursor) {}

    /**
     * 배열 형식의 API 응답 데이터로 PaymentWithCursor 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Payment::fromArray(OperationResponse::requireObject($data, 'payment', self::class)),
            OperationResponse::requireString($data, 'cursor', self::class),
        );
    }
}
