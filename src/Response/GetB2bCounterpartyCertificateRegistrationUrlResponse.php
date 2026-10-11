<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class GetB2bCounterpartyCertificateRegistrationUrlResponse extends OperationResponse
{
    public function __construct(public readonly string $url) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_string($data['url'] ?? null)) {
            throw new \UnexpectedValueException('GetB2bCounterpartyCertificateRegistrationUrlResponse must contain string url.');
        }

        return new self($data['url']);
    }
}
