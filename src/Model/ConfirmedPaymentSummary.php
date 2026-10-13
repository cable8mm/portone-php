<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 결제 수동 승인 완료된 결제 건 요약 정보를 나타내는 모델입니다.
 */
final class ConfirmedPaymentSummary extends OperationResponse
{
    /**
     * ConfirmedPaymentSummary 객체를 초기화합니다.
     */
    public function __construct(public readonly string $pgTxId, public readonly string $paidAt) {}

    /**
     * 배열 형식의 API 응답 데이터로 ConfirmedPaymentSummary 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'pgTxId', self::class),
            self::requireString($data, 'paidAt', self::class),
        );
    }
}
