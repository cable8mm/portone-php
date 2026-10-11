<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class GetKakaopayPaymentOrderResponse extends OperationResponse
{
    public function __construct(public readonly int $statusCode, public readonly string $body) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_int($data['statusCode'] ?? null) || ! is_string($data['body'] ?? null)) {
            throw new \UnexpectedValueException('GetKakaopayPaymentOrderResponse contains invalid fields.');
        }

        return new self($data['statusCode'], $data['body']);
    }
}
