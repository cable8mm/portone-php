<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

final class BulkAccountTransferClient extends AbstractClient
{
    public function getPlatformBulkAccountTransfers(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Model\GetPlatformBulkAccountTransfersResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformBulkAccountTransfers', 'GET', '/platform/bulk-account-transfers', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformBulkAccountTransfersResponse::class);
    }

    public function getPlatformBulkAccountTransfersAsync(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformBulkAccountTransfers', 'GET', '/platform/bulk-account-transfers', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformBulkAccountTransfersResponse::class);
    }
}
