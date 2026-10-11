<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class BulkPayoutClient extends AbstractClient
{
    public function getPlatformBulkPayouts(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Response\GetPlatformBulkPayoutsResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformBulkPayouts', 'GET', '/platform/bulk-payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Response\GetPlatformBulkPayoutsResponse::class);
    }

    public function getPlatformBulkPayoutsAsync(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformBulkPayouts', 'GET', '/platform/bulk-payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Response\GetPlatformBulkPayoutsResponse::class);
    }
}
