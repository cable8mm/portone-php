<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class PlatformAdditionalFeePolicy extends OperationResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $graphqlId,
        public readonly string $name,
        public readonly array $fee,
        public readonly ?string $memo,
        public readonly string $vatPayer,
        public readonly bool $isArchived,
        public readonly string $appliedAt,
        public readonly bool $isForTest,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'id', self::class),
            self::requireString($data, 'graphqlId', self::class),
            self::requireString($data, 'name', self::class),
            self::requireObject($data, 'fee', self::class),
            self::optionalNonNullableString($data, 'memo', self::class),
            self::requireString($data, 'vatPayer', self::class),
            self::requireBool($data, 'isArchived', self::class),
            self::requireString($data, 'appliedAt', self::class),
            self::requireBool($data, 'isForTest', self::class),
        );
    }
}
