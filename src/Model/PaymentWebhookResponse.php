<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class PaymentWebhookResponse extends OperationResponse
{
    public function __construct(
        public readonly string $code,
        public readonly string $header,
        public readonly string $body,
        public readonly string $respondedAt,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        foreach (['code', 'header', 'body', 'respondedAt'] as $field) {
            if (! is_string($data[$field] ?? null)) {
                throw new \UnexpectedValueException('PaymentWebhookResponse must contain string '.$field.'.');
            }
        }

        return new self($data['code'], $data['header'], $data['body'], $data['respondedAt']);
    }
}
