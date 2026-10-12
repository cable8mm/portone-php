<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class GetPlatformTransferSummariesResponse extends OperationResponse
{
    public function __construct(public readonly array $page, public readonly array $transferSummaries) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireObject($data, 'page', self::class),
            self::requireObjectList($data, 'transferSummaries', self::class),
        );
    }
}
