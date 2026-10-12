<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class PaymentSession extends OperationResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $storeId,
        public readonly string $paymentId,
        public readonly string $profileKey,
        public readonly string $country,
        public readonly string $currency,
        public readonly int $totalAmount,
        public readonly string $orderName,
        public readonly string $createdAt,
        public readonly string $expiresAt,
        public readonly ?string $paymentMethod,
        public readonly ?string $redirectUrl,
        /** @var list<PaymentSessionProduct>|null */
        public readonly ?array $products,
        public readonly ?string $customerName,
        public readonly ?string $customerEmail,
        public readonly ?string $storeName,
        /** @var list<PaymentSessionAgreement>|null */
        public readonly ?array $agreements,
        public readonly ?string $orderImageUrl,
        public readonly ?string $customData,
        public readonly ?PaymentSessionColors $colors,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        $products = self::optionalNonNullableObjectList($data, 'products', self::class);
        $agreements = self::optionalNonNullableObjectList($data, 'agreements', self::class);
        $colors = self::optionalNonNullableObject($data, 'colors', self::class);

        return new self(
            self::requireString($data, 'id', self::class),
            self::requireString($data, 'storeId', self::class),
            self::requireString($data, 'paymentId', self::class),
            self::requireString($data, 'profileKey', self::class),
            self::requireString($data, 'country', self::class),
            self::requireString($data, 'currency', self::class),
            self::requireInt($data, 'totalAmount', self::class),
            self::requireString($data, 'orderName', self::class),
            self::requireString($data, 'createdAt', self::class),
            self::requireString($data, 'expiresAt', self::class),
            self::optionalNonNullableString($data, 'paymentMethod', self::class),
            self::optionalNonNullableString($data, 'redirectUrl', self::class),
            $products === null ? null : self::mapObjectList(
                $products,
                static fn (array $product): PaymentSessionProduct => PaymentSessionProduct::fromArray($product),
            ),
            self::optionalNonNullableString($data, 'customerName', self::class),
            self::optionalNonNullableString($data, 'customerEmail', self::class),
            self::optionalNonNullableString($data, 'storeName', self::class),
            $agreements === null ? null : self::mapObjectList(
                $agreements,
                static fn (array $agreement): PaymentSessionAgreement => PaymentSessionAgreement::fromArray($agreement),
            ),
            self::optionalNonNullableString($data, 'orderImageUrl', self::class),
            self::optionalNonNullableString($data, 'customData', self::class),
            $colors === null ? null : PaymentSessionColors::fromArray($colors),
        );
    }
}
