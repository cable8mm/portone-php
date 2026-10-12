<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class Payment extends DiscriminatedResponse
{
    /** Decoded payment method, or null when not present in the payload. */
    public readonly ?PaymentMethod $method;

    /** @param array<string,mixed> $data */
    public function __construct(array $data, string $variant, bool $knownVariant)
    {
        parent::__construct($data, $variant, $knownVariant);

        $methodData = self::optionalObject($data, 'method', self::class);
        $this->method = $methodData !== null ? PaymentMethod::fromArray($methodData) : null;
    }

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'status', [
            'CANCELLED', 'FAILED', 'PAID', 'PARTIAL_CANCELLED', 'PAY_PENDING', 'READY', 'VIRTUAL_ACCOUNT_ISSUED',
        ]);

        if ($known) {
            self::requireFields($data, match ($variant) {
                'CANCELLED' => ['status', 'id', 'transactionId', 'merchantId', 'storeId', 'channel', 'version', 'requestedAt', 'updatedAt', 'statusChangedAt', 'orderName', 'amount', 'currency', 'customer', 'origin', 'cancellations', 'cancelledAt'],
                'FAILED' => ['status', 'id', 'transactionId', 'merchantId', 'storeId', 'version', 'requestedAt', 'updatedAt', 'statusChangedAt', 'orderName', 'amount', 'currency', 'customer', 'origin', 'failedAt', 'failure'],
                'PAID' => ['status', 'id', 'transactionId', 'merchantId', 'storeId', 'channel', 'version', 'requestedAt', 'updatedAt', 'statusChangedAt', 'orderName', 'amount', 'currency', 'customer', 'origin', 'paidAt', 'disputes'],
                'PARTIAL_CANCELLED' => ['status', 'id', 'transactionId', 'merchantId', 'storeId', 'channel', 'version', 'requestedAt', 'updatedAt', 'statusChangedAt', 'orderName', 'amount', 'currency', 'customer', 'origin', 'cancellations', 'cancelledAt'],
                default => ['status', 'id', 'transactionId', 'merchantId', 'storeId', 'channel', 'version', 'requestedAt', 'updatedAt', 'statusChangedAt', 'orderName', 'amount', 'currency', 'customer', 'origin'],
            });
        }

        return new self($data, $variant, $known);
    }
}
