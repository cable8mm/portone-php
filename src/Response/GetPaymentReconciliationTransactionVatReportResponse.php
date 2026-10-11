<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class GetPaymentReconciliationTransactionVatReportResponse extends OperationResponse
{
    public function __construct(
        public readonly ?array $items,
        public readonly array $pgSpecifiers,
        public readonly array $summary,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::optionalObjectList($data, 'items', self::class),
            self::optionalObjectList($data, 'pgSpecifiers', self::class) ?? [],
            self::requireObject($data, 'summary', self::class),
        );
    }
}
