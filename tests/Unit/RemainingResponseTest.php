<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\BillingKeyInfoSummary;
use Cable8mm\PortonePhp\Model\ConfirmIdentityVerificationResponse;
use Cable8mm\PortonePhp\Model\CreatePaymentScheduleResponse;
use Cable8mm\PortonePhp\Model\FailedNotOkResponse;
use Cable8mm\PortonePhp\Model\FailedPgBillingKeyIssueResponse;
use Cable8mm\PortonePhp\Model\IssueBillingKeyResponse;
use Cable8mm\PortonePhp\Model\IssueCashReceiptResponse;
use Cable8mm\PortonePhp\Model\IssuedPgBillingKeyIssueResponse;
use Cable8mm\PortonePhp\Model\PgBillingKeyIssueResponse;
use Cable8mm\PortonePhp\Model\ResendIdentityVerificationResponse;
use Cable8mm\PortonePhp\Model\RevokePaymentSchedulesResponse;
use Cable8mm\PortonePhp\Model\SchedulePlatformPartnersResponse;
use Cable8mm\PortonePhp\Model\SendIdentityVerificationResponse;
use PHPUnit\Framework\TestCase;

final class RemainingResponseTest extends TestCase
{
    public function test_remaining_object_responses_expose_typed_fields(): void
    {
        self::assertSame(['id' => 'verification-id'], ConfirmIdentityVerificationResponse::fromArray([
            'identityVerification' => ['id' => 'verification-id'],
        ])->identityVerification);
        self::assertSame(['id' => 'schedule-id'], CreatePaymentScheduleResponse::fromArray([
            'schedule' => ['id' => 'schedule-id'],
        ])->schedule);
        $billingKeyInfo = IssueBillingKeyResponse::fromArray([
            'billingKeyInfo' => ['billingKey' => 'billing-key-id', 'issuedAt' => '2026-01-01T00:00:00Z'],
            'channelSpecificFailures' => [['channel' => 'pg']],
        ])->billingKeyInfo;
        self::assertInstanceOf(BillingKeyInfoSummary::class, $billingKeyInfo);
        self::assertSame('billing-key-id', $billingKeyInfo->billingKey);
        self::assertSame([['channel' => 'pg']], IssueBillingKeyResponse::fromArray([
            'billingKeyInfo' => ['billingKey' => 'billing-key-id', 'issuedAt' => '2026-01-01T00:00:00Z'],
            'channelSpecificFailures' => [['channel' => 'pg']],
        ])->channelSpecificFailures);
        self::assertSame(['id' => 'cash-receipt-id'], IssueCashReceiptResponse::fromArray([
            'cashReceipt' => ['id' => 'cash-receipt-id'],
        ])->cashReceipt);
        self::assertSame(['reason' => 'failed'], FailedPgBillingKeyIssueResponse::fromArray([
            'channel' => ['id' => 'channel-id'],
            'failure' => ['reason' => 'failed'],
        ])->failure);
        $issued = PgBillingKeyIssueResponse::decode([
            'type' => 'ISSUED',
            'channel' => ['id' => 'channel-id'],
            'pgTxId' => 'pg-tx-id',
        ]);
        self::assertInstanceOf(IssuedPgBillingKeyIssueResponse::class, $issued);
        self::assertSame('pg-tx-id', $issued->pgTxId);
        self::assertSame(['id' => 'channel-id'], $issued->channel());
        $unknown = PgBillingKeyIssueResponse::decode(['type' => 'FUTURE', 'value' => 'preserved']);
        self::assertInstanceOf(PgBillingKeyIssueResponse::class, $unknown);
        self::assertSame(['type' => 'FUTURE', 'value' => 'preserved'], $unknown->payload());
        self::assertNull(IssueBillingKeyResponse::fromArray([
            'billingKeyInfo' => ['billingKey' => 'billing-key-id', 'issuedAt' => '2026-01-01T00:00:00Z'],
        ])->channelSpecificFailures);
        self::assertSame(['schedule-id'], RevokePaymentSchedulesResponse::fromArray([
            'revokedAt' => null,
            'revokedScheduleIds' => ['schedule-id'],
        ])->revokedScheduleIds);
    }

    public function test_empty_success_responses_accept_empty_payloads(): void
    {
        self::assertInstanceOf(FailedNotOkResponse::class, FailedNotOkResponse::fromArray([]));
        self::assertInstanceOf(ResendIdentityVerificationResponse::class, ResendIdentityVerificationResponse::fromArray([]));
        self::assertInstanceOf(SchedulePlatformPartnersResponse::class, SchedulePlatformPartnersResponse::fromArray([]));
        self::assertInstanceOf(SendIdentityVerificationResponse::class, SendIdentityVerificationResponse::fromArray([]));
    }

    public function test_typed_fields_reject_invalid_values(): void
    {
        $cases = [
            static fn (): mixed => ConfirmIdentityVerificationResponse::fromArray(['identityVerification' => 'invalid']),
            static fn (): mixed => IssueBillingKeyResponse::fromArray(['billingKeyInfo' => [], 'channelSpecificFailures' => ['invalid']]),
            static fn (): mixed => IssueCashReceiptResponse::fromArray(['cashReceipt' => 'invalid']),
            static fn (): mixed => RevokePaymentSchedulesResponse::fromArray(['revokedAt' => 1, 'revokedScheduleIds' => []]),
            static fn (): mixed => RevokePaymentSchedulesResponse::fromArray(['revokedAt' => null, 'revokedScheduleIds' => ['invalid' => 'id']]),
            static fn (): mixed => PgBillingKeyIssueResponse::decode(['type' => 'FAILED', 'channel' => [], 'failure' => 'invalid']),
            static fn (): mixed => PgBillingKeyIssueResponse::decode(['type' => 'ISSUED', 'channel' => [], 'pgTxId' => 1]),
        ];

        foreach ($cases as $case) {
            try {
                $case();
                self::fail('Expected invalid response data to be rejected.');
            } catch (\UnexpectedValueException) {
                self::assertTrue(true);
            }
        }
    }
}
