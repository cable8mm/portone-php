<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class CreateOrderTransferResponse extends OperationResponse
{
    public function __construct(public readonly array $transfer) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(self::requireObject($data, 'transfer', self::class));
    }
}
