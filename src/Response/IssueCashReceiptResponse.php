<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class IssueCashReceiptResponse extends OperationResponse
{
    public function __construct(public readonly array $cashReceipt) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(self::requireObject($data, 'cashReceipt', self::class));
    }
}
