<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 영수증 내 하위 상점 거래 등록 응답을 나타내는 모델입니다.
 */
final class RegisterStoreReceiptResponse extends OperationResponse
{
    /**
     * RegisterStoreReceiptResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly ?string $receiptUrl) {}

    /**
     * 배열 형식의 API 응답 데이터로 RegisterStoreReceiptResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        if (($data['receiptUrl'] ?? null) !== null && ! is_string($data['receiptUrl'])) {
            throw new \UnexpectedValueException('RegisterStoreReceiptResponse receiptUrl must be a string or null.');
        }

        return new self($data['receiptUrl'] ?? null);
    }
}
