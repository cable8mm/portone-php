<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 플랫폼 설정을 나타내는 모델입니다.
 */
final class PlatformSetting extends OperationResponse
{
    /**
     * PlatformSetting 객체를 초기화합니다.
     */
    public function __construct(
        public readonly ?string $defaultWithdrawalMemo,
        public readonly ?string $defaultDepositMemo,
        public readonly bool $supportsMultipleOrderTransfersPerPartner,
        public readonly bool $adjustSettlementDateAfterHolidayIfEarlier,
        public readonly bool $deductWht,
        public readonly string $settlementAmountType,
        public readonly bool $isForTest,
        public readonly bool $manualSettlementPerTransfer,
    ) {}

    /**
     * 배열 형식의 API 응답 데이터로 PlatformSetting 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
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
            self::requireBool($data, 'manualSettlementPerTransfer', self::class),
        );
    }
}
