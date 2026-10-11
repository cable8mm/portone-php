<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class PartnerSettlementClient extends AbstractClient
{
    public function deletePlatformPartnerSettlements(mixed $test = null, mixed $partnerSettlementIds = null, mixed $isForTest = null): Response\DeletePlatformPartnerSettlementsResponse
    {
        return $this->callOperationWithQueryAndBody('deletePlatformPartnerSettlements', 'POST', '/platform/partner-settlements/delete', ['test' => $test], ['partnerSettlementIds' => $partnerSettlementIds, 'isForTest' => $isForTest], Response\DeletePlatformPartnerSettlementsResponse::class);
    }

    public function deletePlatformPartnerSettlementsAsync(mixed $test = null, mixed $partnerSettlementIds = null, mixed $isForTest = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('deletePlatformPartnerSettlements', 'POST', '/platform/partner-settlements/delete', ['test' => $test], ['partnerSettlementIds' => $partnerSettlementIds, 'isForTest' => $isForTest], Response\DeletePlatformPartnerSettlementsResponse::class);
    }

    public function getPlatformPartnerSettlements(mixed $test = null, mixed $page = null, mixed $filter = null, mixed $isForTest = null): Response\GetPlatformPartnerSettlementsResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformPartnerSettlements', 'GET', '/platform/partner-settlements', ['test' => $test], ['page' => $page, 'filter' => $filter, 'isForTest' => $isForTest], Response\GetPlatformPartnerSettlementsResponse::class);
    }

    public function getPlatformPartnerSettlementsAsync(mixed $test = null, mixed $page = null, mixed $filter = null, mixed $isForTest = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformPartnerSettlements', 'GET', '/platform/partner-settlements', ['test' => $test], ['page' => $page, 'filter' => $filter, 'isForTest' => $isForTest], Response\GetPlatformPartnerSettlementsResponse::class);
    }
}
