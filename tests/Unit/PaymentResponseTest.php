<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\CancelPaymentResponse;
use Cable8mm\PortonePhp\Model\GetPaymentTransactionsResponse;
use Cable8mm\PortonePhp\Model\PayInstantlyResponse;
use Cable8mm\PortonePhp\Model\PayWithBillingKeyResponse;
use PHPUnit\Framework\TestCase;

final class PaymentResponseTest extends TestCase
{
    public function test_payment_response_envelopes_expose_typed_payloads(): void
    {
        self::assertSame(
            ['id' => 'cancellation-id'],
            CancelPaymentResponse::fromArray(['cancellation' => ['id' => 'cancellation-id']])->cancellation,
        );
        self::assertSame(
            [['id' => 'transaction-id']],
            GetPaymentTransactionsResponse::fromArray(['items' => [['id' => 'transaction-id']]])->items,
        );
        self::assertSame(
            ['id' => 'payment-id'],
            PayInstantlyResponse::fromArray(['payment' => ['id' => 'payment-id']])->payment,
        );
        self::assertSame(
            ['id' => 'payment-id'],
            PayWithBillingKeyResponse::fromArray(['payment' => ['id' => 'payment-id']])->payment,
        );
    }

    public function test_payment_response_envelopes_ignore_extra_fields(): void
    {
        self::assertSame(
            ['id' => 'payment-id'],
            PayInstantlyResponse::fromArray([
                'payment' => ['id' => 'payment-id'],
                'ignored' => true,
            ])->payment,
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
