<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class ReschedulePlatformPartnerResponse extends OperationResponse
{
    public function __construct(public readonly array $scheduledPartner) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['scheduledPartner'] ?? null)) {
            throw new \UnexpectedValueException('ReschedulePlatformPartnerResponse must contain an object.');
        }

        return new self($data['scheduledPartner']);
    }
}
