<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class BulkAccountTransferClient extends AbstractClient
{
    public function getPlatformBulkAccountTransfers(mixed $test = null, mixed $isForTest = null, mixed $page = null, mixed $filter = null): Response\GetPlatformBulkAccountTransfersResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformBulkAccountTransfers', 'GET', '/platform/bulk-account-transfers', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Response\GetPlatformBulkAccountTransfersResponse::class);
    }

    public function getPlatformBulkAccountTransfersAsync(mixed $test = null, mixed $isForTest = null, mixed $page = null, mixed $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformBulkAccountTransfers', 'GET', '/platform/bulk-account-transfers', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Response\GetPlatformBulkAccountTransfersResponse::class);
    }
}
