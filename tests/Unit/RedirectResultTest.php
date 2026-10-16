<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Browser\RedirectResult;
use PHPUnit\Framework\TestCase;

/**
 * T-063 — Browser redirect result and payment-request values.
 *
 * Covers (shapes traced to the PortOne V2 browser-SDK documentation):
 *  - Success and failure redirect queries parse to the matching typed values.
 *  - A missing, empty, or non-string paymentId throws InvalidArgumentException (ERR-011).
 *  - isFailure is true exactly when code is present.
 *  - Extra query keys are ignored.
 */
final class RedirectResultTest extends TestCase
{
    public function test_success_redirect_query_parses_without_error(): void
    {
        $result = RedirectResult::fromQuery(['paymentId' => 'payment-39ecfa97']);

        $this->assertSame('payment-39ecfa97', $result->paymentId);
        $this->assertNull($result->code);
        $this->assertNull($result->message);
        $this->assertNull($result->pgCode);
        $this->assertNull($result->pgMessage);
        $this->assertFalse($result->isFailure());
    }

    public function test_failure_redirect_query_reports_failure(): void
    {
        $result = RedirectResult::fromQuery([
            'paymentId' => 'payment-39ecfa97',
            'code' => 'FAILURE_TYPE_PG',
            'message' => 'Payment failed.',
            'pgCode' => 'PG-001',
            'pgMessage' => 'PG message.',
        ]);

        $this->assertSame('payment-39ecfa97', $result->paymentId);
        $this->assertSame('FAILURE_TYPE_PG', $result->code);
        $this->assertSame('Payment failed.', $result->message);
        $this->assertSame('PG-001', $result->pgCode);
        $this->assertSame('PG message.', $result->pgMessage);
        $this->assertTrue($result->isFailure());
    }

    public function test_extra_query_keys_are_ignored(): void
    {
        $result = RedirectResult::fromQuery(['paymentId' => 'payment-1', 'txId' => 'tx-1']);

        $this->assertSame('payment-1', $result->paymentId);
        $this->assertFalse($result->isFailure());
    }

    public function test_missing_or_invalid_payment_id_throws(): void
    {
        $invalid = [
            [],
            ['paymentId' => ''],
            ['paymentId' => null],
            ['paymentId' => 123],
        ];

        foreach ($invalid as $query) {
            try {
                RedirectResult::fromQuery($query);
                self::fail('Expected a missing or invalid paymentId to be rejected.');
            } catch (\InvalidArgumentException) {
                self::assertTrue(true);
            }
        }
    }

    public function test_non_string_error_fields_throw(): void
    {
        try {
            RedirectResult::fromQuery(['paymentId' => 'payment-1', 'code' => 123]);
            self::fail('Expected a non-string code to be rejected.');
        } catch (\InvalidArgumentException) {
            self::assertTrue(true);
        }
    }
}
