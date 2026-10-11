<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class IdentityVerification extends DiscriminatedResponse
{
    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'status', ['FAILED', 'READY', 'VERIFIED']);

        if ($known) {
            self::requireFields($data, match ($variant) {
                'FAILED' => ['status', 'id', 'requestedCustomer', 'requestedAt', 'updatedAt', 'statusChangedAt', 'failure', 'version'],
                'READY' => ['status', 'id', 'requestedCustomer', 'requestedAt', 'updatedAt', 'statusChangedAt', 'version'],
                default => ['status', 'id', 'verifiedCustomer', 'requestedAt', 'updatedAt', 'statusChangedAt', 'verifiedAt', 'pgTxId', 'pgRawResponse', 'version'],
            });
        }

        return new self($data, $variant, $known);
    }
}
