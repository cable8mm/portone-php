<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class ArchivePlatformDiscountSharePolicyResponse extends OperationResponse
{
    public function __construct(public readonly array $discountSharePolicy) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['discountSharePolicy'] ?? null)) {
            throw new \UnexpectedValueException('ArchivePlatformDiscountSharePolicyResponse must contain a discountSharePolicy object.');
        }

        return new self($data['discountSharePolicy']);
    }
}
