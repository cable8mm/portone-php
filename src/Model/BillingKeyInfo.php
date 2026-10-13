<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 빌링키 정보를 나타내는 모델입니다.
 */
final class BillingKeyInfo extends DiscriminatedResponse
{
    /**
     * 배열 형식의 API 응답 데이터로 BillingKeyInfo 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'status', ['DELETED', 'ISSUED']);

        if ($known) {
            self::requireFields($data, $variant === 'DELETED'
                ? ['status', 'billingKey', 'merchantId', 'storeId', 'channels', 'customer', 'issuedAt', 'deletedAt']
                : ['status', 'billingKey', 'merchantId', 'storeId', 'channels', 'customer', 'issuedAt']);
        }

        return new self($data, $variant, $known);
    }
}
