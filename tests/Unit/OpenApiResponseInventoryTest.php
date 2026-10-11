<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use PHPUnit\Framework\TestCase;

final class OpenApiResponseInventoryTest extends TestCase
{
    public function test_openapi_response_inventory_reports_every_operation(): void
    {
        $process = proc_open(
            [PHP_BINARY, dirname(__DIR__, 2).'/tools/openapi_response_inventory.php'],
            [1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
            $pipes,
            dirname(__DIR__, 2),
        );

        self::assertIsResource($process);
        $output = stream_get_contents($pipes[1]);
        $errors = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $exitCode = proc_close($process);

        self::assertSame('', $errors);
        self::assertSame(0, $exitCode);

        $report = json_decode($output, true, 512, JSON_THROW_ON_ERROR);
        self::assertSame(147, $report['summary']['operations']);
        self::assertArrayHasKey('getPayment', $report['operations']);
        self::assertArrayHasKey('missingFields', $report['operations']['getPayment']);
        self::assertArrayHasKey('unions', $report['operations']['getBillingKeyInfo']);
        self::assertSame('match', $report['operations']['getBankInfos']['status']);
        self::assertSame('match', $report['operations']['evaluateCheckoutProfile']['status']);
        self::assertSame('match', $report['operations']['createPaymentSession']['status']);
        self::assertSame('match', $report['operations']['getPaymentSession']['status']);
        self::assertSame('match', $report['operations']['closePaymentSession']['status']);
    }
}
