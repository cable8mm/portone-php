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

    /**
     * Live-captured KCP mobile redirect queries (2026-10-17, test store).
     *
     * Success carries no code but extra transactionType/txId keys; the MPOINT
     * failure carries code, message, pgCode, and pgMessage together with
     * paymentId. Both shapes parse to the documented values.
     */
    public function test_live_captured_redirect_queries_parse(): void
    {
        $success = RedirectResult::fromQuery([
            'paymentId' => '21806b0f-8393-4ebb-aa71-6901d9474be2',
            'transactionType' => 'PAYMENT',
            'txId' => '01a146be-b15e-75f3-c4b7-a162f19048ff',
        ]);

        $this->assertSame('21806b0f-8393-4ebb-aa71-6901d9474be2', $success->paymentId);
        $this->assertFalse($success->isFailure());

        $failure = RedirectResult::fromQuery([
            'code' => 'PG_PROVIDER_ERROR',
            'message' => '결제 승인 과정에서 문제가 발생하였습니다. MPOINT 가맹점 미등록',
            'paymentId' => 'e7e72327-eb4a-4032-87e5-c8c315465f4a',
            'pgCode' => '8285',
            'pgMessage' => 'MPOINT 가맹점 미등록',
            'transactionType' => 'PAYMENT',
            'txId' => '01a146bc-befe-f322-e876-b5f5608e8106',
        ]);

        $this->assertSame('e7e72327-eb4a-4032-87e5-c8c315465f4a', $failure->paymentId);
        $this->assertTrue($failure->isFailure());
        $this->assertSame('PG_PROVIDER_ERROR', $failure->code);
        $this->assertSame('8285', $failure->pgCode);
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
