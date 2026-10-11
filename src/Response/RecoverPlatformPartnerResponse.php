<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class RecoverPlatformPartnerResponse extends OperationResponse
{
    public function __construct(public readonly array $partner) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['partner'] ?? null)) {
            throw new \UnexpectedValueException('RecoverPlatformPartnerResponse must contain a partner object.');
        }

        return new self($data['partner']);
    }
}
