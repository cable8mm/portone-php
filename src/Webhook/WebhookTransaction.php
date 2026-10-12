<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Webhook;

use DateTimeImmutable;

/**
 * Typed webhook for all Transaction.* events.
 *
 * Observed/documented PortOne V2 transaction event types:
 *  Transaction.Ready, Transaction.Paid, Transaction.VirtualAccountIssued,
 *  Transaction.PartialCancelled, Transaction.Cancelled, Transaction.Failed,
 *  Transaction.PayPending, Transaction.CancelPending, Transaction.DisputeCreated
 *
 * Source: https://developers.portone.io (webhook documentation)
 * Live observation: Transaction.Paid received in T-051 E2E probe.
 */
final class WebhookTransaction implements Webhook
{
    /** Known transaction event types per PortOne V2 documentation. */
    public const KNOWN_TYPES = [
        'Transaction.Ready',
        'Transaction.Paid',
        'Transaction.VirtualAccountIssued',
        'Transaction.PartialCancelled',
        'Transaction.Cancelled',
        'Transaction.Failed',
        'Transaction.PayPending',
        'Transaction.CancelPending',
        'Transaction.DisputeCreated',
    ];

    public function __construct(
        public readonly string $type,
        public readonly DateTimeImmutable $timestamp,
        public readonly WebhookTransactionData $data,
    ) {}

    /** @param array<string,mixed> $body */
    public static function fromArray(array $body): self
    {
        $type = $body['type'] ?? null;
        $timestamp = $body['timestamp'] ?? null;
        if (! is_string($type) || ! is_string($timestamp) || ! is_array($body['data'] ?? null)) {
            throw new \UnexpectedValueException('Invalid Transaction webhook body.');
        }

        return new self($type, new DateTimeImmutable($timestamp), WebhookTransactionData::fromArray($body['data']));
    }
}
