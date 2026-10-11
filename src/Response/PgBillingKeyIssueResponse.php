<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class PgBillingKeyIssueResponse extends OperationResponse
{
    /** @param array<string,mixed> $payload */
    public function __construct(
        public readonly array $channel,
        private readonly array $payload,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(is_array($data['channel'] ?? null) ? $data['channel'] : [], $data);
    }

    /** @param array<string,mixed> $data */
    public static function decode(array $data): OperationResponse
    {
        return match ($data['type'] ?? null) {
            'FAILED' => FailedPgBillingKeyIssueResponse::fromArray($data),
            'ISSUED' => IssuedPgBillingKeyIssueResponse::fromArray($data),
            default => self::fromArray($data),
        };
    }

    /** @return array<string,mixed> */
    public function payload(): array
    {
        return $this->payload;
    }
}
