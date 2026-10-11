<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class PlatformSetting extends OperationResponse
{
    public function __construct(
        public readonly ?string $defaultWithdrawalMemo,
        public readonly ?string $defaultDepositMemo,
        public readonly bool $supportsMultipleOrderTransfersPerPartner,
        public readonly bool $adjustSettlementDateAfterHolidayIfEarlier,
        public readonly bool $deductWht,
        public readonly string $settlementAmountType,
        public readonly bool $isForTest,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::optionalString($data, 'defaultWithdrawalMemo', self::class),
            self::optionalString($data, 'defaultDepositMemo', self::class),
            self::requireBool($data, 'supportsMultipleOrderTransfersPerPartner', self::class),
            self::requireBool($data, 'adjustSettlementDateAfterHolidayIfEarlier', self::class),
            self::requireBool($data, 'deductWht', self::class),
            self::requireString($data, 'settlementAmountType', self::class),
            self::requireBool($data, 'isForTest', self::class),
        );
    }
}
