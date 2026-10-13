<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 B2bCertificate 데이터를 나타내는 모델입니다.
 */
final class B2bCertificate extends OperationResponse
{
    /**
     * B2bCertificate 객체를 초기화합니다.
     */
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

    /**
     * 배열 형식의 API 응답 데이터로 B2bCertificate 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
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
