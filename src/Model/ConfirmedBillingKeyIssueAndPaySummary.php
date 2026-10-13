<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 빌링키 발급 및 초회 결제 수동 승인 완료 응답을 나타내는 모델입니다.
 */
final class ConfirmedBillingKeyIssueAndPaySummary extends OperationResponse
{
    /**
     * ConfirmedBillingKeyIssueAndPaySummary 객체를 초기화합니다.
     */
    public function __construct(public readonly string $billingKey, public readonly string $paymentId) {}

    /**
     * 배열 형식의 API 응답 데이터로 ConfirmedBillingKeyIssueAndPaySummary 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'billingKey', self::class),
            self::requireString($data, 'paymentId', self::class),
        );
    }
}
