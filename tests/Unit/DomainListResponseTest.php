<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\GetBillingKeyInfosResponse;
use Cable8mm\PortonePhp\Model\GetPaymentReconciliationSettlementVatReportResponse;
use Cable8mm\PortonePhp\Model\GetPgCardPromotionsResponse;
use PHPUnit\Framework\TestCase;

final class DomainListResponseTest extends TestCase
{
    public function test_domain_list_responses_expose_items_pages_and_optional_lists(): void
    {
        self::assertSame(['number' => 0], GetBillingKeyInfosResponse::fromArray([
            'items' => [['status' => 'FUTURE', 'id' => 'billing-key-id']],
            'page' => ['number' => 0],
        ])->page);
        self::assertNull(GetPgCardPromotionsResponse::fromArray([])->promotions);
        self::assertSame([['id' => 'promotion-id']], GetPgCardPromotionsResponse::fromArray([
            'promotions' => [['id' => 'promotion-id']],
        ])->promotions);
        self::assertSame(['total' => 0], GetPaymentReconciliationSettlementVatReportResponse::fromArray([
            'summary' => ['total' => 0],
        ])->summary);
    }

    public function test_required_domain_list_fields_reject_invalid_shapes(): void
    {
        $this->expectException(\UnexpectedValueException::class);
        GetBillingKeyInfosResponse::fromArray(['items' => [], 'page' => 'invalid']);
    }
}
