<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class EvaluateCheckoutProfileResponse extends OperationResponse
{
    /** @param list<array<string,mixed>>|null $methods */
    public function __construct(public readonly ?array $methods) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(self::optionalObjectList($data, 'methods', self::class));
    }
}
