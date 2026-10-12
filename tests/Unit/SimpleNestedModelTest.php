<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\B2bCertificate;
use Cable8mm\PortonePhp\Model\CreateB2bFileUploadUrlPayload;
use Cable8mm\PortonePhp\Model\PlatformAccountHolder;
use Cable8mm\PortonePhp\Model\PlatformDiscountSharePolicyFilterOptions;
use Cable8mm\PortonePhp\Model\PlatformPartnerFilterOptions;
use Cable8mm\PortonePhp\Model\PlatformSetting;
use PHPUnit\Framework\TestCase;

final class SimpleNestedModelTest extends TestCase
{
    public function test_simple_nested_models_expose_typed_fields(): void
    {
        self::assertSame('SHINHAN', PlatformAccountHolder::fromArray([
            'holderName' => 'SHINHAN',
            'accountVerificationId' => 'verification-id',
        ])->holderName);
        self::assertFalse(PlatformSetting::fromArray([
            'defaultWithdrawalMemo' => null,
            'defaultDepositMemo' => null,
            'supportsMultipleOrderTransfersPerPartner' => false,
            'adjustSettlementDateAfterHolidayIfEarlier' => true,
            'deductWht' => false,
            'settlementAmountType' => 'SUPPLY_AMOUNT',
            'isForTest' => true,
            'manualSettlementPerTransfer' => false,
        ])->supportsMultipleOrderTransfersPerPartner);
        self::assertSame(['tag'], PlatformPartnerFilterOptions::fromArray([
            'tags' => ['tag'],
            'contractSummary' => [['id' => 'contract-id']],
        ])->tags);
        self::assertSame([10, 20], PlatformDiscountSharePolicyFilterOptions::fromArray([
            'partnerShareRates' => [10, 20],
        ])->partnerShareRates);
        self::assertSame('https://example.test/upload', CreateB2bFileUploadUrlPayload::fromArray([
            'fileId' => 'file-id',
            'url' => 'https://example.test/upload',
        ])->url);
        self::assertSame('certificate-id', B2bCertificate::fromArray([
            'registeredAt' => '2026-01-01T00:00:00Z',
            'expiredAt' => '2027-01-01T00:00:00Z',
            'issuerName' => 'issuer',
            'subjectName' => 'subject',
            'certificateType' => 'TAX',
            'oid' => 'certificate-id',
            'registrantContactName' => 'contact',
            'registrantContactId' => 'contact-id',
        ])->oid);
    }

    public function test_simple_nested_models_reject_invalid_scalars(): void
    {
        $cases = [
            static fn (): mixed => PlatformAccountHolder::fromArray(['holderName' => 1, 'accountVerificationId' => 'id']),
            static fn (): mixed => PlatformSetting::fromArray(['supportsMultipleOrderTransfersPerPartner' => 'false']),
            static fn (): mixed => PlatformPartnerFilterOptions::fromArray(['tags' => [1], 'contractSummary' => []]),
            static fn (): mixed => PlatformDiscountSharePolicyFilterOptions::fromArray(['partnerShareRates' => ['10']]),
            static fn (): mixed => CreateB2bFileUploadUrlPayload::fromArray(['fileId' => 'id']),
            static fn (): mixed => B2bCertificate::fromArray(['registeredAt' => 1]),
        ];

        foreach ($cases as $case) {
            try {
                $case();
                self::fail('Expected invalid nested model data to be rejected.');
            } catch (\UnexpectedValueException) {
                self::assertTrue(true);
            }
        }
    }
}
