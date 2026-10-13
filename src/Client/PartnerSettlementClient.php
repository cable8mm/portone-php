<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 플랫폼 파트너 정산 API 작업을 제공합니다.
 */
final class PartnerSettlementClient extends AbstractClient
{
    /**
     * 정산내역 삭제 기능입니다.
     * 선택한 정산내역들을 삭제합니다.
     */
    public function deletePlatformPartnerSettlements(?bool $test = null, ?array $partnerSettlementIds = null, ?bool $isForTest = null): Model\DeletePlatformPartnerSettlementsResponse
    {
        return $this->callOperationWithQueryAndBody('deletePlatformPartnerSettlements', 'POST', '/platform/partner-settlements/delete', ['test' => $test], ['partnerSettlementIds' => $partnerSettlementIds, 'isForTest' => $isForTest], Model\DeletePlatformPartnerSettlementsResponse::class);
    }

    /**
     * 정산내역 삭제 기능입니다.
     * 선택한 정산내역들을 삭제합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function deletePlatformPartnerSettlementsAsync(?bool $test = null, ?array $partnerSettlementIds = null, ?bool $isForTest = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('deletePlatformPartnerSettlements', 'POST', '/platform/partner-settlements/delete', ['test' => $test], ['partnerSettlementIds' => $partnerSettlementIds, 'isForTest' => $isForTest], Model\DeletePlatformPartnerSettlementsResponse::class);
    }

    /**
     * 정산 내역 다건 조회 기능입니다.
     * 여러 정산 내역을 조회합니다.
     */
    public function getPlatformPartnerSettlements(?bool $test = null, ?array $page = null, ?array $filter = null, ?bool $isForTest = null): Model\GetPlatformPartnerSettlementsResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformPartnerSettlements', 'GET', '/platform/partner-settlements', ['test' => $test], ['page' => $page, 'filter' => $filter, 'isForTest' => $isForTest], Model\GetPlatformPartnerSettlementsResponse::class);
    }

    /**
     * 정산 내역 다건 조회 기능입니다.
     * 여러 정산 내역을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformPartnerSettlementsAsync(?bool $test = null, ?array $page = null, ?array $filter = null, ?bool $isForTest = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformPartnerSettlements', 'GET', '/platform/partner-settlements', ['test' => $test], ['page' => $page, 'filter' => $filter, 'isForTest' => $isForTest], Model\GetPlatformPartnerSettlementsResponse::class);
    }
}
