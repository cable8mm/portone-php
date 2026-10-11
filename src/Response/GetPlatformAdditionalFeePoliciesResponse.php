<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class GetPlatformAdditionalFeePoliciesResponse extends OperationResponse
{
    public function __construct(public readonly array $items, public readonly array $page) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireObjectList($data, 'items', self::class),
            self::requireObject($data, 'page', self::class),
        );
    }
}
