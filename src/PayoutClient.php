<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class PayoutClient extends AbstractClient
{
    public function completePlatformPayoutByPartnerSettlementIds(?bool $test = null, ?string $bulkPayoutId = null, ?string $name = null, ?array $partnerSettlementIds = null, ?string $completedAt = null, ?bool $isForTest = null): Response\CompletePlatformPayoutByPartnerSettlementIdsResponse
    {
        return $this->callOperationWithQueryAndBody('completePlatformPayoutByPartnerSettlementIds', 'POST', '/platform/partner-settlements/complete-payout', ['test' => $test], ['bulkPayoutId' => $bulkPayoutId, 'name' => $name, 'partnerSettlementIds' => $partnerSettlementIds, 'completedAt' => $completedAt, 'isForTest' => $isForTest], Response\CompletePlatformPayoutByPartnerSettlementIdsResponse::class);
    }

    public function completePlatformPayoutByPartnerSettlementIdsAsync(?bool $test = null, ?string $bulkPayoutId = null, ?string $name = null, ?array $partnerSettlementIds = null, ?string $completedAt = null, ?bool $isForTest = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('completePlatformPayoutByPartnerSettlementIds', 'POST', '/platform/partner-settlements/complete-payout', ['test' => $test], ['bulkPayoutId' => $bulkPayoutId, 'name' => $name, 'partnerSettlementIds' => $partnerSettlementIds, 'completedAt' => $completedAt, 'isForTest' => $isForTest], Response\CompletePlatformPayoutByPartnerSettlementIdsResponse::class);
    }

    public function getPlatformPayouts(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Response\GetPlatformPayoutsResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformPayouts', 'GET', '/platform/payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Response\GetPlatformPayoutsResponse::class);
    }

    public function getPlatformPayoutsAsync(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformPayouts', 'GET', '/platform/payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Response\GetPlatformPayoutsResponse::class);
    }
}
