<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class ConfirmIdentityVerificationResponse extends OperationResponse
{
    public function __construct(public readonly array $identityVerification) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(self::requireObject($data, 'identityVerification', self::class));
    }
}
