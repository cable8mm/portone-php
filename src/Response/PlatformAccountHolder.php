<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class PlatformAccountHolder extends OperationResponse
{
    public function __construct(public readonly string $holderName, public readonly string $accountVerificationId) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'holderName', self::class),
            self::requireString($data, 'accountVerificationId', self::class),
        );
    }
}
