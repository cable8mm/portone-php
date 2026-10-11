<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class PlatformDiscountSharePolicyFilterOptions extends OperationResponse
{
    /** @param list<int> $partnerShareRates */
    public function __construct(public readonly array $partnerShareRates) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(self::requireIntList($data, 'partnerShareRates', self::class));
    }
}
