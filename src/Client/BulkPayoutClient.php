<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 플랫폼 대량 지급 API 작업을 제공합니다.
 */
final class BulkPayoutClient extends AbstractClient
{
    /**
     * 일괄 지급 내역 다건 조회 기능입니다.
     * 성공 응답으로 조회된 일괄 지급 내역 리스트와 페이지 정보 및 상태 별 개수 정보를 반환합니다.
     */
    public function getPlatformBulkPayouts(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Model\GetPlatformBulkPayoutsResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformBulkPayouts', 'GET', '/platform/bulk-payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformBulkPayoutsResponse::class);
    }

    /**
     * 일괄 지급 내역 다건 조회 기능입니다.
     * 성공 응답으로 조회된 일괄 지급 내역 리스트와 페이지 정보 및 상태 별 개수 정보를 반환합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformBulkPayoutsAsync(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformBulkPayouts', 'GET', '/platform/bulk-payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformBulkPayoutsResponse::class);
    }
}
