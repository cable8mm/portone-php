<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class EvaluatedCheckoutMethod
{
    public function __construct(public readonly string $paymentMethod, public readonly string $channelKey) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            OperationResponse::requireString($data, 'paymentMethod', self::class),
            OperationResponse::requireString($data, 'channelKey', self::class),
        );
    }
}
