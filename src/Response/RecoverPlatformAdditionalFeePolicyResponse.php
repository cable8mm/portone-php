<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class RecoverPlatformAdditionalFeePolicyResponse extends OperationResponse
{
    public function __construct(public readonly array $additionalFeePolicy) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['additionalFeePolicy'] ?? null)) {
            throw new \UnexpectedValueException('RecoverPlatformAdditionalFeePolicyResponse must contain an additionalFeePolicy object.');
        }

        return new self($data['additionalFeePolicy']);
    }
}
