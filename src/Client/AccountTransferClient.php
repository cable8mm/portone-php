<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

final class AccountTransferClient extends AbstractClient
{
    public function getPlatformAccountTransfers(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Model\GetPlatformAccountTransfersResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformAccountTransfers', 'GET', '/platform/account-transfers', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformAccountTransfersResponse::class);
    }

    public function getPlatformAccountTransfersAsync(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformAccountTransfers', 'GET', '/platform/account-transfers', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformAccountTransfersResponse::class);
    }
}
