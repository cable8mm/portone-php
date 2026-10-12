<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class B2bCounterparty extends OperationResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $graphqlId,
        public readonly bool $isForTest,
        public readonly string $brn,
        public readonly string $companyName,
        public readonly string $representativeName,
        public readonly ?string $address,
        public readonly ?string $businessType,
        public readonly ?string $businessClass,
        public readonly array $contact,
        public readonly array $additionalContacts,
        public readonly ?string $memo,
        public readonly string $ntsConnectionStatus,
        public readonly ?string $ntsConnectedAt,
        public readonly ?string $ntsConnectionFailedReason,
        public readonly ?string $partnerId,
        public readonly ?string $businessStatus,
        public readonly ?string $businessStatusCheckedAt,
        public readonly ?array $businessStatusVerification,
        public readonly ?array $businessInfoVerification,
        public readonly ?string $appliedAt,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'id', self::class),
            self::requireString($data, 'graphqlId', self::class),
            self::requireBool($data, 'isForTest', self::class),
            self::requireString($data, 'brn', self::class),
            self::requireString($data, 'companyName', self::class),
            self::requireString($data, 'representativeName', self::class),
            self::optionalNonNullableString($data, 'address', self::class),
            self::optionalNonNullableString($data, 'businessType', self::class),
            self::optionalNonNullableString($data, 'businessClass', self::class),
            self::requireObject($data, 'contact', self::class),
            self::requireObjectList($data, 'additionalContacts', self::class),
            self::optionalNonNullableString($data, 'memo', self::class),
            self::requireString($data, 'ntsConnectionStatus', self::class),
            self::optionalNonNullableString($data, 'ntsConnectedAt', self::class),
            self::optionalNonNullableString($data, 'ntsConnectionFailedReason', self::class),
            self::optionalNonNullableString($data, 'partnerId', self::class),
            self::optionalNonNullableObject($data, 'businessStatus', self::class),
            self::optionalNonNullableString($data, 'businessStatusCheckedAt', self::class),
            self::optionalNonNullableObject($data, 'businessStatusVerification', self::class),
            self::optionalNonNullableObject($data, 'businessInfoVerification', self::class),
            self::optionalNonNullableString($data, 'appliedAt', self::class),
        );
    }
}
