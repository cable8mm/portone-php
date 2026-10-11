<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class DisconnectBulkPartnerCounterpartyResponse extends OperationResponse
{
    public function __construct(public readonly array $bulkTask) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(self::requireObject($data, 'bulkTask', self::class));
    }
}
