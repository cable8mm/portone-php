<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 플랫폼 지급 API 작업을 제공합니다.
 */
final class PayoutClient extends AbstractClient
{
    /**
     * 일괄 지급 완료 처리 기능입니다.
     * 선택한 정산내역 아이디들로 일괄 지급을 완료 처리 합니다.
     */
    public function completePlatformPayoutByPartnerSettlementIds(?bool $test = null, ?string $bulkPayoutId = null, ?string $name = null, ?array $partnerSettlementIds = null, ?string $completedAt = null, ?bool $isForTest = null): Model\CompletePlatformPayoutByPartnerSettlementIdsResponse
    {
        return $this->callOperationWithQueryAndBody('completePlatformPayoutByPartnerSettlementIds', 'POST', '/platform/partner-settlements/complete-payout', ['test' => $test], ['bulkPayoutId' => $bulkPayoutId, 'name' => $name, 'partnerSettlementIds' => $partnerSettlementIds, 'completedAt' => $completedAt, 'isForTest' => $isForTest], Model\CompletePlatformPayoutByPartnerSettlementIdsResponse::class);
    }

    /**
     * 일괄 지급 완료 처리 기능입니다.
     * 선택한 정산내역 아이디들로 일괄 지급을 완료 처리 합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function completePlatformPayoutByPartnerSettlementIdsAsync(?bool $test = null, ?string $bulkPayoutId = null, ?string $name = null, ?array $partnerSettlementIds = null, ?string $completedAt = null, ?bool $isForTest = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('completePlatformPayoutByPartnerSettlementIds', 'POST', '/platform/partner-settlements/complete-payout', ['test' => $test], ['bulkPayoutId' => $bulkPayoutId, 'name' => $name, 'partnerSettlementIds' => $partnerSettlementIds, 'completedAt' => $completedAt, 'isForTest' => $isForTest], Model\CompletePlatformPayoutByPartnerSettlementIdsResponse::class);
    }

    /**
     * 지급 내역 다건 조회 기능입니다.
     * 여러 지급 내역을 조회합니다.
     */
    public function getPlatformPayouts(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Model\GetPlatformPayoutsResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformPayouts', 'GET', '/platform/payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformPayoutsResponse::class);
    }

    /**
     * 지급 내역 다건 조회 기능입니다.
     * 여러 지급 내역을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformPayoutsAsync(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformPayouts', 'GET', '/platform/payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformPayoutsResponse::class);
    }
}
