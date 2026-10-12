<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\GetPlatformAccountTransfersResponse;
use Cable8mm\PortonePhp\Model\GetPlatformPartnersResponse;
use Cable8mm\PortonePhp\Model\GetPlatformTransferSummariesResponse;
use PHPUnit\Framework\TestCase;

final class PlatformListResponseTest extends TestCase
{
    public function test_platform_list_envelopes_expose_lists_and_pages(): void
    {
        $accountTransfers = GetPlatformAccountTransfersResponse::fromArray([
            'counts' => ['PENDING' => 1],
            'items' => [['id' => 'transfer-id']],
            'page' => ['number' => 0],
        ]);
        self::assertSame(['id' => 'transfer-id'], $accountTransfers->items[0]);

        self::assertSame(['number' => 0], GetPlatformPartnersResponse::fromArray([
            'items' => [['id' => 'partner-id']],
            'page' => ['number' => 0],
        ])->page);
        self::assertSame(['id' => 'summary-id'], GetPlatformTransferSummariesResponse::fromArray([
            'page' => ['number' => 0],
            'transferSummaries' => [['id' => 'summary-id']],
        ])->transferSummaries[0]);
    }

    public function test_platform_list_envelopes_reject_invalid_members(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        GetPlatformPartnersResponse::fromArray(['items' => ['invalid'], 'page' => []]);
    }
}
