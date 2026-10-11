<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class UpdatePlatformDiscountSharePolicyResponse extends OperationResponse
{
    public function __construct(public readonly array $discountSharePolicy) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['discountSharePolicy'] ?? null)) {
            throw new \UnexpectedValueException('UpdatePlatformDiscountSharePolicyResponse must contain an object.');
        }

        return new self($data['discountSharePolicy']);
    }
}
