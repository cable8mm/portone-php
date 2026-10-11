<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class FailedPgBillingKeyIssueResponse extends OperationResponse
{
    public function __construct(public readonly array $failure) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(self::requireObject($data, 'failure', self::class));
    }
}
