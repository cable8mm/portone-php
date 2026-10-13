<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 CreateOrderTransferResponse 데이터를 나타내는 모델입니다.
 */
final class CreateOrderTransferResponse extends OperationResponse
{
    /**
     * CreateOrderTransferResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly array $transfer) {}

    /**
     * 배열 형식의 API 응답 데이터로 CreateOrderTransferResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self(self::requireObject($data, 'transfer', self::class));
    }
}
