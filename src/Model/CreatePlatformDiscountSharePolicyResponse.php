<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class CreatePlatformDiscountSharePolicyResponse extends OperationResponse
{
    public function __construct(public readonly array $discountSharePolicy) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['discountSharePolicy'] ?? null)) {
            throw new \UnexpectedValueException('CreatePlatformDiscountSharePolicyResponse must contain a discountSharePolicy object.');
        }

        return new self($data['discountSharePolicy']);
    }
}
