<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class UpdatePlatformPartnerResponse extends OperationResponse
{
    public function __construct(public readonly array $partner) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['partner'] ?? null)) {
            throw new \UnexpectedValueException('UpdatePlatformPartnerResponse must contain an object.');
        }

        return new self($data['partner']);
    }
}
