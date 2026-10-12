<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

final class PayoutClient extends AbstractClient
{
    public function completePlatformPayoutByPartnerSettlementIds(?bool $test = null, ?string $bulkPayoutId = null, ?string $name = null, ?array $partnerSettlementIds = null, ?string $completedAt = null, ?bool $isForTest = null): Model\CompletePlatformPayoutByPartnerSettlementIdsResponse
    {
        return $this->callOperationWithQueryAndBody('completePlatformPayoutByPartnerSettlementIds', 'POST', '/platform/partner-settlements/complete-payout', ['test' => $test], ['bulkPayoutId' => $bulkPayoutId, 'name' => $name, 'partnerSettlementIds' => $partnerSettlementIds, 'completedAt' => $completedAt, 'isForTest' => $isForTest], Model\CompletePlatformPayoutByPartnerSettlementIdsResponse::class);
    }

    public function completePlatformPayoutByPartnerSettlementIdsAsync(?bool $test = null, ?string $bulkPayoutId = null, ?string $name = null, ?array $partnerSettlementIds = null, ?string $completedAt = null, ?bool $isForTest = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('completePlatformPayoutByPartnerSettlementIds', 'POST', '/platform/partner-settlements/complete-payout', ['test' => $test], ['bulkPayoutId' => $bulkPayoutId, 'name' => $name, 'partnerSettlementIds' => $partnerSettlementIds, 'completedAt' => $completedAt, 'isForTest' => $isForTest], Model\CompletePlatformPayoutByPartnerSettlementIdsResponse::class);
    }

    public function getPlatformPayouts(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Model\GetPlatformPayoutsResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformPayouts', 'GET', '/platform/payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformPayoutsResponse::class);
    }

    public function getPlatformPayoutsAsync(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformPayouts', 'GET', '/platform/payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformPayoutsResponse::class);
    }
}
