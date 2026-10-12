<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class EvaluateCheckoutProfileResponse extends OperationResponse
{
    /** @param list<EvaluatedCheckoutMethod>|null $methods */
    public function __construct(public readonly ?array $methods) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        $methods = self::optionalNonNullableObjectList($data, 'methods', self::class);

        return new self($methods === null ? null : self::mapObjectList(
            $methods,
            static fn (array $method): EvaluatedCheckoutMethod => EvaluatedCheckoutMethod::fromArray($method),
        ));
    }
}
