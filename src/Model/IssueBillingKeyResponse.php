<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class IssueBillingKeyResponse extends OperationResponse
{
    /** @param list<array<string,mixed>>|null $channelSpecificFailures */
    public function __construct(
        public readonly array $billingKeyInfo,
        public readonly ?array $channelSpecificFailures,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireObject($data, 'billingKeyInfo', self::class),
            self::optionalObjectList($data, 'channelSpecificFailures', self::class),
        );
    }
}
