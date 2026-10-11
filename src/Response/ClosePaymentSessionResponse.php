<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class ClosePaymentSessionResponse extends OperationResponse
{
    public function __construct(public readonly string $closedAt) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(self::requireString($data, 'closedAt', self::class));
    }
}
