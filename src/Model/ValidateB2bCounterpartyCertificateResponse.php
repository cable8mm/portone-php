<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class ValidateB2bCounterpartyCertificateResponse extends OperationResponse
{
    public function __construct(public readonly bool $isValid) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_bool($data['isValid'] ?? null)) {
            throw new \UnexpectedValueException('ValidateB2bCounterpartyCertificateResponse must contain boolean isValid.');
        }

        return new self($data['isValid']);
    }
}
