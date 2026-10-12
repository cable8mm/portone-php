<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class ReschedulePlatformAdditionalFeePolicyResponse extends OperationResponse
{
    public function __construct(public readonly array $scheduledAdditionalFeePolicy) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['scheduledAdditionalFeePolicy'] ?? null)) {
            throw new \UnexpectedValueException('ReschedulePlatformAdditionalFeePolicyResponse must contain an object.');
        }

        return new self($data['scheduledAdditionalFeePolicy']);
    }
}
