<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * Typed representation of a PortOne V2 PaymentMethod.
 *
 * Discriminated by the `type` field. Known variants per OpenAPI schema:
 *   PaymentMethodCard, PaymentMethodEasyPay, PaymentMethodTransfer,
 *   PaymentMethodVirtualAccount, PaymentMethodMobile, PaymentMethodGiftCertificate,
 *   PaymentMethodConvenienceStore, PaymentMethodCrypto
 *
 * Unknown variants are stored with knownVariant=false and the full payload
 * preserved in $data, ensuring forward compatibility.
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

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'type', self::KNOWN_TYPES);

        return new self($data, $variant, $known);
    }
}
