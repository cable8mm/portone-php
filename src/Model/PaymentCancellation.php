<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 결제 취소 내역을 나타내는 모델입니다.
 */
final class PaymentCancellation extends DiscriminatedResponse
{
    /**
     * 배열 형식의 API 응답 데이터로 PaymentCancellation 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'status', ['FAILED', 'REQUESTED', 'SUCCEEDED']);

        if ($known) {
            self::requireFields($data, [
                'status', 'id', 'totalAmount', 'taxFreeAmount', 'vatAmount', 'reason', 'requestedAt',
            ]);
        }

        return new self($data, $variant, $known);
    }
}
