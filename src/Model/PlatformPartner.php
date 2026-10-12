<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class PlatformPartner extends OperationResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $graphqlId,
        public readonly string $name,
        public readonly array $contact,
        public readonly array $account,
        public readonly string $status,
        public readonly string $defaultContractId,
        public readonly ?string $memo,
        public readonly array $tags,
        public readonly string $type,
        public readonly bool $isArchived,
        public readonly string $appliedAt,
        public readonly array $userDefinedProperties,
        public readonly bool $isForTest,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'id', self::class), self::requireString($data, 'graphqlId', self::class),
            self::requireString($data, 'name', self::class), self::requireObject($data, 'contact', self::class),
            self::requireObject($data, 'account', self::class), self::requireString($data, 'status', self::class),
            self::requireString($data, 'defaultContractId', self::class), self::optionalNonNullableString($data, 'memo', self::class),
            self::requireStringList($data, 'tags', self::class), self::requireString($data, 'type', self::class),
            self::requireBool($data, 'isArchived', self::class), self::requireString($data, 'appliedAt', self::class),
            self::requireObject($data, 'userDefinedProperties', self::class), self::requireBool($data, 'isForTest', self::class),
        );
    }
}
