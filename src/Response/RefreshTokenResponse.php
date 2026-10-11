<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class RefreshTokenResponse extends OperationResponse
{
    public function __construct(
        public readonly string $accessToken,
        public readonly string $refreshToken,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_string($data['accessToken'] ?? null) || ! is_string($data['refreshToken'] ?? null)) {
            throw new \UnexpectedValueException('RefreshTokenResponse must contain string accessToken and refreshToken fields.');
        }

        return new self($data['accessToken'], $data['refreshToken']);
    }
}
