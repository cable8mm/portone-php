<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Response\ConfirmedBillingKeyIssueAndPaySummary;
use Cable8mm\PortonePhp\Response\ConfirmedBillingKeySummary;
use Cable8mm\PortonePhp\Response\ConfirmedPaymentSummary;
use Cable8mm\PortonePhp\Response\GetPlatformCompanyStatePayload;
use PHPUnit\Framework\TestCase;

final class ConfirmationResponseTest extends TestCase
{
    public function test_confirmation_and_company_payloads_expose_typed_fields(): void
    {
        self::assertSame('billing-key', ConfirmedBillingKeySummary::fromArray([
            'billingKey' => 'billing-key',
        ])->billingKey);
        self::assertSame('payment-id', ConfirmedBillingKeyIssueAndPaySummary::fromArray([
            'billingKey' => 'billing-key',
            'paymentId' => 'payment-id',
        ])->paymentId);
        self::assertSame('pg-tx-id', ConfirmedPaymentSummary::fromArray([
            'pgTxId' => 'pg-tx-id',
            'paidAt' => '2026-01-01T00:00:00Z',
        ])->pgTxId);
        self::assertSame(['status' => 'ACTIVE'], GetPlatformCompanyStatePayload::fromArray([
            'companyState' => ['status' => 'ACTIVE'],
            'companyVerificationId' => 'verification-id',
        ])->companyState);
    }

    public function test_confirmation_and_company_payloads_reject_invalid_values(): void
    {
        $cases = [
            static fn (): mixed => ConfirmedBillingKeySummary::fromArray([]),
            static fn (): mixed => ConfirmedBillingKeyIssueAndPaySummary::fromArray(['billingKey' => 'key']),
            static fn (): mixed => ConfirmedPaymentSummary::fromArray(['pgTxId' => 1, 'paidAt' => 'time']),
            static fn (): mixed => GetPlatformCompanyStatePayload::fromArray(['companyState' => 'invalid', 'companyVerificationId' => 'id']),
        ];

        foreach ($cases as $case) {
            try {
                $case();
                self::fail('Expected invalid confirmation data to be rejected.');
            } catch (\UnexpectedValueException) {
                self::assertTrue(true);
            }
        }
    }
}
