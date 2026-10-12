<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Webhook;

/**
 * Common data payload for BillingKey.* webhook events.
 *
 * Fields observed from PortOne V2 webhook documentation:
 *  - billingKey, storeId — present on all BillingKey.* events
 */
final class WebhookBillingKeyData
{
    public function __construct(
        public readonly string $billingKey,
        public readonly string $storeId,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            (string) ($data['billingKey'] ?? ''),
            (string) ($data['storeId'] ?? ''),
        );
    }
}
