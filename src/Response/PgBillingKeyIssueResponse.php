<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class PgBillingKeyIssueResponse extends OperationResponse
{
    public function __construct(public readonly array $channel) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(self::requireObject($data, 'channel', self::class));
    }
}
