<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class ReschedulePlatformDiscountSharePolicyResponse extends OperationResponse
{
    public function __construct(public readonly array $scheduledDiscountSharePolicy) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['scheduledDiscountSharePolicy'] ?? null)) {
            throw new \UnexpectedValueException('ReschedulePlatformDiscountSharePolicyResponse must contain an object.');
        }

        return new self($data['scheduledDiscountSharePolicy']);
    }
}
