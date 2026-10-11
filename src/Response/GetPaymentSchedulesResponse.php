<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class GetPaymentSchedulesResponse extends OperationResponse
{
    /** @param list<PaymentSchedule> $items */
    public function __construct(public readonly array $items, public readonly array $page) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(self::mapObjectList(self::requireObjectList($data, 'items', self::class), static fn (array $item): PaymentSchedule => PaymentSchedule::fromArray($item)), self::requireObject($data, 'page', self::class));
    }
}
