<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class ApplyEscrowLogisticsResponse extends OperationResponse
{
    public function __construct(
        public readonly string $invoiceNumber,
        public readonly string $sentAt,
        public readonly string $appliedAt,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        foreach (['invoiceNumber', 'sentAt', 'appliedAt'] as $field) {
            if (! is_string($data[$field] ?? null)) {
                throw new \UnexpectedValueException('ApplyEscrowLogisticsResponse must contain string '.$field.'.');
            }
        }

        return new self($data['invoiceNumber'], $data['sentAt'], $data['appliedAt']);
    }
}
