<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class GetPlatformBulkPayoutsResponse extends OperationResponse
{
    public function __construct(
        public readonly array $counts,
        public readonly array $items,
        public readonly array $page,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireObject($data, 'counts', self::class),
            self::requireObjectList($data, 'items', self::class),
            self::requireObject($data, 'page', self::class),
        );
    }
}
