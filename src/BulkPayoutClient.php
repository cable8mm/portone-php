<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class BulkPayoutClient extends AbstractClient
{
    public function getPlatformBulkPayouts(mixed $test = null, mixed $isForTest = null, mixed $page = null, mixed $filter = null): Response\GetPlatformBulkPayoutsResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformBulkPayouts', 'GET', '/platform/bulk-payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Response\GetPlatformBulkPayoutsResponse::class);
    }

    public function getPlatformBulkPayoutsAsync(mixed $test = null, mixed $isForTest = null, mixed $page = null, mixed $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformBulkPayouts', 'GET', '/platform/bulk-payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Response\GetPlatformBulkPayoutsResponse::class);
    }
}
