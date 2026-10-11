<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class PlatformPartnerFilterOptions extends OperationResponse
{
    /** @param list<string> $tags @param list<array<string,mixed>> $contractSummary */
    public function __construct(public readonly array $tags, public readonly array $contractSummary) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireStringList($data, 'tags', self::class),
            self::requireObjectList($data, 'contractSummary', self::class),
        );
    }
}
