<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class ConfirmPaymentwallDeliveryResponse extends OperationResponse
{
    public function __construct() {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self;
    }
}
