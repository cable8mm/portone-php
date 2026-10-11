<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class SchedulePlatformPartnerResponse extends OperationResponse
{
    public function __construct(public readonly array $scheduledPartner) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['scheduledPartner'] ?? null)) {
            throw new \UnexpectedValueException('SchedulePlatformPartnerResponse must contain an object.');
        }

        return new self($data['scheduledPartner']);
    }
}
