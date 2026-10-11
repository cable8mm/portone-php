<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class PaymentSessionAgreement
{
    public function __construct(public readonly string $name, public readonly string $url) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            OperationResponse::requireString($data, 'name', self::class),
            OperationResponse::requireString($data, 'url', self::class),
        );
    }
}
