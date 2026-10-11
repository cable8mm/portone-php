<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class PayoutClient extends AbstractClient
{
    public function completePlatformPayoutByPartnerSettlementIds(mixed $test = null, mixed $bulkPayoutId = null, mixed $name = null, mixed $partnerSettlementIds = null, mixed $completedAt = null, mixed $isForTest = null): Response\CompletePlatformPayoutByPartnerSettlementIdsResponse
    {
        return $this->callOperationWithQueryAndBody('completePlatformPayoutByPartnerSettlementIds', 'POST', '/platform/partner-settlements/complete-payout', ['test' => $test], ['bulkPayoutId' => $bulkPayoutId, 'name' => $name, 'partnerSettlementIds' => $partnerSettlementIds, 'completedAt' => $completedAt, 'isForTest' => $isForTest], Response\CompletePlatformPayoutByPartnerSettlementIdsResponse::class);
    }

    public function completePlatformPayoutByPartnerSettlementIdsAsync(mixed $test = null, mixed $bulkPayoutId = null, mixed $name = null, mixed $partnerSettlementIds = null, mixed $completedAt = null, mixed $isForTest = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('completePlatformPayoutByPartnerSettlementIds', 'POST', '/platform/partner-settlements/complete-payout', ['test' => $test], ['bulkPayoutId' => $bulkPayoutId, 'name' => $name, 'partnerSettlementIds' => $partnerSettlementIds, 'completedAt' => $completedAt, 'isForTest' => $isForTest], Response\CompletePlatformPayoutByPartnerSettlementIdsResponse::class);
    }

    public function getPlatformPayouts(mixed $test = null, mixed $isForTest = null, mixed $page = null, mixed $filter = null): Response\GetPlatformPayoutsResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformPayouts', 'GET', '/platform/payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Response\GetPlatformPayoutsResponse::class);
    }

    public function getPlatformPayoutsAsync(mixed $test = null, mixed $isForTest = null, mixed $page = null, mixed $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformPayouts', 'GET', '/platform/payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Response\GetPlatformPayoutsResponse::class);
    }
}
