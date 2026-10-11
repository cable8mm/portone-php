<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

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
        public readonly ?array $paymentMethod,
        public readonly ?string $redirectUrl,
        public readonly ?array $products,
        public readonly ?string $customerName,
        public readonly ?string $customerEmail,
        public readonly ?string $storeName,
        public readonly ?array $agreements,
        public readonly ?string $orderImageUrl,
        public readonly ?string $customData,
        public readonly ?array $colors,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        $paymentMethod = self::optionalObject($data, 'paymentMethod', self::class);
        $products = self::optionalObjectList($data, 'products', self::class);
        $agreements = self::optionalObjectList($data, 'agreements', self::class);
        $colors = self::optionalObject($data, 'colors', self::class);

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
            $paymentMethod,
            self::optionalString($data, 'redirectUrl', self::class),
            $products,
            self::optionalString($data, 'customerName', self::class),
            self::optionalString($data, 'customerEmail', self::class),
            self::optionalString($data, 'storeName', self::class),
            $agreements,
            self::optionalString($data, 'orderImageUrl', self::class),
            self::optionalString($data, 'customData', self::class),
            $colors,
        );
    }
}
