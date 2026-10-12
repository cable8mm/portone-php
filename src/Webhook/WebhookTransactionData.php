<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Webhook;

/**
 * Common data payload for Transaction.* webhook events.
 *
 * Fields observed in live PortOne V2 webhook (docs: https://developers.portone.io):
 *  - paymentId, transactionId, storeId — always present on transaction events
 *  - cancellationId — present on Transaction.Cancelled, Transaction.PartialCancelled
 */
final class WebhookTransactionData
{
    public function __construct(
        public readonly string $paymentId,
        public readonly string $storeId,
        public readonly string $transactionId,
        public readonly ?string $cancellationId = null,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            (string) ($data['paymentId'] ?? ''),
            (string) ($data['storeId'] ?? ''),
            (string) ($data['transactionId'] ?? ''),
            isset($data['cancellationId']) ? (string) $data['cancellationId'] : null,
        );
    }
}
