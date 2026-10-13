<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 프로모션을 나타내는 모델입니다.
 */
final class Promotion extends DiscriminatedResponse
{
    /**
     * 배열 형식의 API 응답 데이터로 Promotion 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'type', ['CARD']);

        if ($known) {
            self::requireFields($data, ['type', 'id', 'storeId', 'name', 'discountPolicy', 'totalBudget', 'spentAmount', 'currency', 'startAt', 'endAt', 'cardCompany', 'status', 'createdAt', 'recoverOption']);
        }

        return new self($data, $variant, $known);
    }
}
