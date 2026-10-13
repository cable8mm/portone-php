<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 플랫폼 계좌 이체 API 작업을 제공합니다.
 */
final class AccountTransferClient extends AbstractClient
{
    /**
     * 이체 내역 다건 조회 기능입니다.
     * 여러 이체 내역을 조회합니다.
     */
    public function getPlatformAccountTransfers(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Model\GetPlatformAccountTransfersResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformAccountTransfers', 'GET', '/platform/account-transfers', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformAccountTransfersResponse::class);
    }

    /**
     * 이체 내역 다건 조회 기능입니다.
     * 여러 이체 내역을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformAccountTransfersAsync(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformAccountTransfers', 'GET', '/platform/account-transfers', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformAccountTransfersResponse::class);
    }
}
