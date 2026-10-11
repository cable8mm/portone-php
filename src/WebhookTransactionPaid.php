<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

use DateTimeImmutable;

final class WebhookTransactionPaid implements Webhook
{
    public readonly string $type;

    public function __construct(
        public readonly DateTimeImmutable $timestamp,
        public readonly WebhookTransactionDataPaid $data,
    ) {
        $this->type = 'Transaction.Paid';
    }

    /** @param array<string,mixed> $body */
    public static function fromArray(array $body): self
    {
        $timestamp = $body['timestamp'] ?? null;
        if (! is_string($timestamp) || ! is_array($body['data'] ?? null)) {
            throw new \UnexpectedValueException('Invalid Transaction.Paid webhook body.');
        }

        return new self(new DateTimeImmutable($timestamp), WebhookTransactionDataPaid::fromArray($body['data']));
    }
}
