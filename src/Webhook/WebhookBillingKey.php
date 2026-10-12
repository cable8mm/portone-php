<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Webhook;

use DateTimeImmutable;

/**
 * Typed webhook for all BillingKey.* events.
 *
 * Observed/documented PortOne V2 billing key event types:
 *  BillingKey.Ready, BillingKey.Issued, BillingKey.Failed,
 *  BillingKey.Deleted, BillingKey.Updated
 *
 * Source: https://developers.portone.io (webhook documentation)
 */
final class WebhookBillingKey implements Webhook
{
    /** Known billing key event types per PortOne V2 documentation. */
    public const KNOWN_TYPES = [
        'BillingKey.Ready',
        'BillingKey.Issued',
        'BillingKey.Failed',
        'BillingKey.Deleted',
        'BillingKey.Updated',
    ];

    public function __construct(
        public readonly string $type,
        public readonly DateTimeImmutable $timestamp,
        public readonly WebhookBillingKeyData $data,
    ) {}

    /** @param array<string,mixed> $body */
    public static function fromArray(array $body): self
    {
        $type = $body['type'] ?? null;
        $timestamp = $body['timestamp'] ?? null;
        if (! is_string($type) || ! is_string($timestamp) || ! is_array($body['data'] ?? null)) {
            throw new \UnexpectedValueException('Invalid BillingKey webhook body.');
        }

        return new self($type, new DateTimeImmutable($timestamp), WebhookBillingKeyData::fromArray($body['data']));
    }
}
