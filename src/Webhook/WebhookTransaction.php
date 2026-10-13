<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Webhook;

use DateTimeImmutable;

/**
 * Transaction.* 이벤트의 검증된 웹훅을 타입이 지정된 객체로 나타냅니다.
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

    /**
     * WebhookTransaction 객체를 초기화합니다.
     */
    public function __construct(
        public readonly string $type,
        public readonly DateTimeImmutable $timestamp,
        public readonly WebhookTransactionData $data,
    ) {}

    /**
     * 배열 형식의 API 응답 데이터로 WebhookTransaction 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $body
     * @return static 변환된 객체입니다.
     */
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
