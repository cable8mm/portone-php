<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class CreatePaymentSessionResponse extends OperationResponse
{
    public function __construct(public readonly string $sessionId, public readonly string $url, public readonly string $expiresAt) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'sessionId', self::class),
            self::requireString($data, 'url', self::class),
            self::requireString($data, 'expiresAt', self::class),
        );
    }
}
