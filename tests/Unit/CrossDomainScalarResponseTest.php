<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\CancelCashReceiptResponse;
use Cable8mm\PortonePhp\Model\CompletePlatformPayoutByPartnerSettlementIdsResponse;
use Cable8mm\PortonePhp\Model\GetB2bCounterpartyCertificateRegistrationUrlResponse;
use Cable8mm\PortonePhp\Model\GetKakaopayPaymentOrderResponse;
use Cable8mm\PortonePhp\Model\ValidateB2bCounterpartyCertificateResponse;
use PHPUnit\Framework\TestCase;

final class CrossDomainScalarResponseTest extends TestCase
{
    public function test_scalar_response_fields_are_decoded(): void
    {
        self::assertSame(100, CancelCashReceiptResponse::fromArray([
            'cancelledAmount' => 100,
            'cancelledAt' => '2026-01-01T00:00:00Z',
        ])->cancelledAmount);
        self::assertSame('https://example.test/certificate', GetB2bCounterpartyCertificateRegistrationUrlResponse::fromArray([
            'url' => 'https://example.test/certificate',
        ])->url);
        self::assertSame('body', GetKakaopayPaymentOrderResponse::fromArray([
            'statusCode' => 200,
            'body' => 'body',
        ])->body);
        self::assertTrue(ValidateB2bCounterpartyCertificateResponse::fromArray(['isValid' => true])->isValid);
        self::assertNull(CompletePlatformPayoutByPartnerSettlementIdsResponse::fromArray([
            'payoutCount' => 1,
            'partnerSettlementCount' => 2,
        ])->bulkPayoutId);
    }

    public function test_empty_response_classes_decode_without_raw_data(): void
    {
        foreach ([
            'CancelPlatformAdditionalFeePolicyScheduleResponse',
            'CancelPlatformContractScheduleResponse',
            'CancelPlatformDiscountSharePolicyScheduleResponse',
            'CancelPlatformPartnerScheduleResponse',
            'DeleteB2bCounterpartyResponse',
            'DeleteB2bTaxInvoiceResponse',
            'DeletePlatformPartnerSettlementsResponse',
            'DeletePlatformTransferResponse',
            'ConfirmPaymentwallDeliveryResponse',
        ] as $name) {
            $class = 'Cable8mm\\PortonePhp\\Model\\'.$name;
            self::assertInstanceOf($class, $class::fromArray(['ignored' => true]));
        }
    }
}
