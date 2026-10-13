<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 결제 수단을 나타내며, type 필드로 유형을 구분합니다. 알 수 없는 유형도 전체 데이터를 보존합니다.
 */
final class PaymentMethod extends DiscriminatedResponse
{
    /** Known payment method type values per OpenAPI discriminator mapping. */
    public const KNOWN_TYPES = [
        'PaymentMethodCard',
        'PaymentMethodConvenienceStore',
        'PaymentMethodCrypto',
        'PaymentMethodEasyPay',
        'PaymentMethodGiftCertificate',
        'PaymentMethodMobile',
        'PaymentMethodTransfer',
        'PaymentMethodVirtualAccount',
    ];

    /**
     * 배열 형식의 API 응답 데이터로 PaymentMethod 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'type', self::KNOWN_TYPES);

        return new self($data, $variant, $known);
    }
}
