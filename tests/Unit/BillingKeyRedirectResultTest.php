<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Browser\BillingKeyRedirectResult;
use PHPUnit\Framework\TestCase;

/**
 * T-067 — Browser billing-key redirect result.
 *
 * Covers (query shapes traced to tests/fixtures/billing-key-redirect-boundary-observations.json, T-066):
 *  - The recorded success query (billingKey only) parses to a non-failure with billingKey.
 *  - The recorded failure query (billingKey, code, message, pgCode, pgMessage) parses to a failure with billingKey null (FR-035).
 *  - isFailure is true exactly when code is present.
 *  - A query without code and without a non-empty billingKey string throws InvalidArgumentException (ERR-012).
 *  - Extra query keys are ignored.
 */
final class BillingKeyRedirectResultTest extends TestCase
{
    /**
     * @return array<string,mixed>
     */
    private static function recordedRun(string $run): array
    {
        $observations = json_decode(
            (string) file_get_contents(__DIR__.'/../fixtures/billing-key-redirect-boundary-observations.json'),
            true,
            flags: JSON_THROW_ON_ERROR,
        );

        return $observations['runs'][$run];
    }

    public function test_recorded_success_query_parses_with_billing_key(): void
    {
        $run = self::recordedRun('success');
        $result = BillingKeyRedirectResult::fromQuery($run['query']);

        $this->assertSame(['billingKey'], $run['queryKeys']);
        $this->assertSame($run['query']['billingKey'], $result->billingKey);
        $this->assertNull($result->code);
        $this->assertNull($result->message);
        $this->assertNull($result->pgCode);
        $this->assertNull($result->pgMessage);
        $this->assertFalse($result->isFailure());
    }

    public function test_recorded_failure_query_reports_failure_without_billing_key(): void
    {
        $run = self::recordedRun('failure');
        $result = BillingKeyRedirectResult::fromQuery($run['query']);

        $this->assertArrayHasKey('billingKey', $run['query']);
        $this->assertNull($result->billingKey);
        $this->assertSame('FAILURE_TYPE_PG', $result->code);
        $this->assertSame('[3001] 사용자 결제 취소', $result->message);
        $this->assertSame('3001', $result->pgCode);
        $this->assertSame('사용자 결제 취소', $result->pgMessage);
        $this->assertTrue($result->isFailure());
    }

    public function test_failure_query_without_billing_key_reports_failure(): void
    {
        $result = BillingKeyRedirectResult::fromQuery(['code' => 'FAILURE_TYPE_PG']);

        $this->assertNull($result->billingKey);
        $this->assertTrue($result->isFailure());
    }

    public function test_extra_query_keys_are_ignored(): void
    {
        $result = BillingKeyRedirectResult::fromQuery(['billingKey' => 'billing-key-1', 'issueId' => 'issue-1']);

        $this->assertSame('billing-key-1', $result->billingKey);
        $this->assertFalse($result->isFailure());
    }

    public function test_success_query_without_billing_key_throws(): void
    {
        $invalid = [
            [],
            ['billingKey' => ''],
            ['billingKey' => null],
            ['billingKey' => 123],
        ];

        foreach ($invalid as $query) {
            try {
                BillingKeyRedirectResult::fromQuery($query);
                self::fail('Expected a success query without a billingKey to be rejected.');
            } catch (\InvalidArgumentException) {
                self::assertTrue(true);
            }
        }
    }

    public function test_non_string_error_fields_throw(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        BillingKeyRedirectResult::fromQuery(['billingKey' => 'billing-key-1', 'code' => 123]);
    }
}
