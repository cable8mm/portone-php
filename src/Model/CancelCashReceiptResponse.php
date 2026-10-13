<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 현금 영수증 취소 성공 응답을 나타내는 모델입니다.
 */
final class CancelCashReceiptResponse extends OperationResponse
{
    /**
     * CancelCashReceiptResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly int $cancelledAmount, public readonly string $cancelledAt) {}

    /**
     * 배열 형식의 API 응답 데이터로 CancelCashReceiptResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        if (! is_int($data['cancelledAmount'] ?? null) || ! is_string($data['cancelledAt'] ?? null)) {
            throw new \UnexpectedValueException('CancelCashReceiptResponse contains invalid fields.');
        }

        return new self($data['cancelledAmount'], $data['cancelledAt']);
    }
}
