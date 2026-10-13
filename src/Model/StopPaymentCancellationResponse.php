<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 결제 취소 요청 취소 성공 응답을 나타내는 모델입니다.
 */
final class StopPaymentCancellationResponse extends OperationResponse
{
    /**
     * StopPaymentCancellationResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly string $stoppedAt) {}

    /**
     * 배열 형식의 API 응답 데이터로 StopPaymentCancellationResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        if (! is_string($data['stoppedAt'] ?? null)) {
            throw new \UnexpectedValueException('StopPaymentCancellationResponse must contain string stoppedAt.');
        }

        return new self($data['stoppedAt']);
    }
}
