<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\BillingKeyPaymentSummary;
use Cable8mm\PortonePhp\Model\CancelPaymentResponse;
use Cable8mm\PortonePhp\Model\GetPaymentTransactionsResponse;
use Cable8mm\PortonePhp\Model\InstantPaymentSummary;
use Cable8mm\PortonePhp\Model\PayInstantlyResponse;
use Cable8mm\PortonePhp\Model\PaymentCancellation;
use Cable8mm\PortonePhp\Model\PayWithBillingKeyResponse;
use PHPUnit\Framework\TestCase;

final class PaymentResponseTest extends TestCase
{
    public function test_payment_response_envelopes_expose_typed_payloads(): void
    {
        $cancellation = CancelPaymentResponse::fromArray(['cancellation' => [
            'status' => 'SUCCEEDED', 'id' => 'cancellation-id', 'totalAmount' => 1004,
            'taxFreeAmount' => 0, 'vatAmount' => 0, 'reason' => 'test', 'requestedAt' => '2026-01-01T00:00:00Z',
        ]])->cancellation;
        self::assertInstanceOf(PaymentCancellation::class, $cancellation);
        self::assertSame('SUCCEEDED', $cancellation->variant);
        self::assertSame(
            [['id' => 'transaction-id']],
            GetPaymentTransactionsResponse::fromArray(['items' => [['id' => 'transaction-id']]])->items,
        );
        $payment = PayInstantlyResponse::fromArray(['payment' => ['pgTxId' => 'pg-tx-id', 'paidAt' => '2026-01-01T00:00:00Z']])->payment;
        self::assertInstanceOf(InstantPaymentSummary::class, $payment);
        self::assertSame('pg-tx-id', $payment->pgTxId);
        $billingKeyPayment = PayWithBillingKeyResponse::fromArray(['payment' => [
            'pgTxId' => 'pg-tx-id', 'paidAt' => '2026-01-01T00:00:00Z',
        ]])->payment;
        self::assertInstanceOf(BillingKeyPaymentSummary::class, $billingKeyPayment);
        self::assertSame('pg-tx-id', $billingKeyPayment->pgTxId);
    }

    public function test_payment_response_envelopes_ignore_extra_fields(): void
    {
        self::assertSame(
            'pg-tx-id',
            PayInstantlyResponse::fromArray([
                'payment' => ['pgTxId' => 'pg-tx-id', 'paidAt' => '2026-01-01T00:00:00Z'],
                'ignored' => true,
            ])->payment->pgTxId,
        );
    }

    public function test_payment_response_envelopes_reject_invalid_shapes(): void
    {
        $invalid = [
            static fn (): mixed => CancelPaymentResponse::fromArray(['cancellation' => 'invalid']),
            static fn (): mixed => GetPaymentTransactionsResponse::fromArray(['items' => ['invalid']]),
            static fn (): mixed => PayInstantlyResponse::fromArray(['payment' => 'invalid']),
            static fn (): mixed => PayWithBillingKeyResponse::fromArray(['payment' => 'invalid']),
        ];

        foreach ($invalid as $case) {
            try {
                $case();
                self::fail('Expected an invalid response shape to be rejected.');
            } catch (\UnexpectedValueException) {
                self::assertTrue(true);
            }
        }
    }
}
