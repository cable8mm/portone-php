<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class SchedulePlatformContractResponse extends OperationResponse
{
    public function __construct(public readonly array $scheduledContract) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['scheduledContract'] ?? null)) {
            throw new \UnexpectedValueException('SchedulePlatformContractResponse must contain an object.');
        }

        return new self($data['scheduledContract']);
    }
}
