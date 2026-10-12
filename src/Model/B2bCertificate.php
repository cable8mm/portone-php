<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class B2bCertificate extends OperationResponse
{
    public function __construct(
        public readonly string $registeredAt,
        public readonly string $expiredAt,
        public readonly string $issuerName,
        public readonly string $subjectName,
        public readonly string $certificateType,
        public readonly string $oid,
        public readonly string $registrantContactName,
        public readonly string $registrantContactId,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'registeredAt', self::class),
            self::requireString($data, 'expiredAt', self::class),
            self::requireString($data, 'issuerName', self::class),
            self::requireString($data, 'subjectName', self::class),
            self::requireString($data, 'certificateType', self::class),
            self::requireString($data, 'oid', self::class),
            self::requireString($data, 'registrantContactName', self::class),
            self::requireString($data, 'registrantContactId', self::class),
        );
    }
}
