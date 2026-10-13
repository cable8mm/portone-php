<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 정산건을 나타내는 모델입니다.
 */
final class PlatformTransfer extends DiscriminatedResponse
{
    /**
     * 배열 형식의 API 응답 데이터로 PlatformTransfer 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'type', ['MANUAL', 'ORDER', 'ORDER_CANCEL']);

        if ($known) {
            self::requireFields($data, ['type', 'id', 'graphqlId', 'partner', 'status', 'settlementDate', 'settlementCurrency', 'isForTest', 'userDefinedProperties']);
        }

        return new self($data, $variant, $known);
    }
}
