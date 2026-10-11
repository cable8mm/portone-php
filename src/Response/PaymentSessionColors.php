<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class PaymentSessionColors
{
    public function __construct(
        public readonly ?string $primary,
        public readonly ?string $primaryHover,
        public readonly ?string $primaryLight,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            OperationResponse::optionalNonNullableString($data, 'primary', self::class),
            OperationResponse::optionalNonNullableString($data, 'primaryHover', self::class),
            OperationResponse::optionalNonNullableString($data, 'primaryLight', self::class),
        );
    }
}
