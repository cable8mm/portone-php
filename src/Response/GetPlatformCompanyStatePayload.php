<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class GetPlatformCompanyStatePayload extends OperationResponse
{
    public function __construct(public readonly array $companyState, public readonly string $companyVerificationId) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireObject($data, 'companyState', self::class),
            self::requireString($data, 'companyVerificationId', self::class),
        );
    }
}
