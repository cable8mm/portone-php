<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class GetAllPaymentEventsByCursorResponse extends OperationResponse
{
    /** @param list<PaymentEvent> $items */
    public function __construct(public readonly array $items) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        $items = self::requireObjectList($data, 'items', self::class);

        return new self(self::mapObjectList(
            $items,
            static fn (array $item): PaymentEvent => PaymentEvent::fromArray($item),
        ));
    }
}
