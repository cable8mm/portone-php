<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class BulkAccountTransferClient extends AbstractClient
{
    public function getPlatformBulkAccountTransfers(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Response\GetPlatformBulkAccountTransfersResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformBulkAccountTransfers', 'GET', '/platform/bulk-account-transfers', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Response\GetPlatformBulkAccountTransfersResponse::class);
    }

    public function getPlatformBulkAccountTransfersAsync(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformBulkAccountTransfers', 'GET', '/platform/bulk-account-transfers', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Response\GetPlatformBulkAccountTransfersResponse::class);
    }
}
