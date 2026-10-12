<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Webhook;

final class WebhookTransactionDataPaid
{
    public function __construct(
        public readonly string $paymentId,
        public readonly string $storeId,
        public readonly string $transactionId,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            (string) ($data['paymentId'] ?? ''),
            (string) ($data['storeId'] ?? ''),
            (string) ($data['transactionId'] ?? ''),
        );
    }
}
