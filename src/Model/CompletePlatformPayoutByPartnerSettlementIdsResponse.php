<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 일괄 지급 완료 처리 결과를 나타내는 모델입니다.
 */
final class CompletePlatformPayoutByPartnerSettlementIdsResponse extends OperationResponse
{
    /**
     * CompletePlatformPayoutByPartnerSettlementIdsResponse 객체를 초기화합니다.
     */
    public function __construct(
        public readonly ?string $bulkPayoutId,
        public readonly ?string $bulkPayoutGraphqlId,
        public readonly int $payoutCount,
        public readonly int $partnerSettlementCount,
    ) {}

    /**
     * 배열 형식의 API 응답 데이터로 CompletePlatformPayoutByPartnerSettlementIdsResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        foreach (['bulkPayoutId', 'bulkPayoutGraphqlId'] as $field) {
            if (($data[$field] ?? null) !== null && ! is_string($data[$field])) {
                throw new \UnexpectedValueException('CompletePlatformPayoutByPartnerSettlementIdsResponse contains invalid '.$field.'.');
            }
        }
        if (! is_int($data['payoutCount'] ?? null) || ! is_int($data['partnerSettlementCount'] ?? null)) {
            throw new \UnexpectedValueException('CompletePlatformPayoutByPartnerSettlementIdsResponse contains invalid counts.');
        }

        return new self($data['bulkPayoutId'] ?? null, $data['bulkPayoutGraphqlId'] ?? null, $data['payoutCount'], $data['partnerSettlementCount']);
    }
}
