<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class ModifyEscrowLogisticsResponse extends OperationResponse
{
    public function __construct(
        public readonly string $invoiceNumber,
        public readonly string $sentAt,
        public readonly string $modifiedAt,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        foreach (['invoiceNumber', 'sentAt', 'modifiedAt'] as $field) {
            if (! is_string($data[$field] ?? null)) {
                throw new \UnexpectedValueException('ModifyEscrowLogisticsResponse must contain string '.$field.'.');
            }
        }

        return new self($data['invoiceNumber'], $data['sentAt'], $data['modifiedAt']);
    }
}
