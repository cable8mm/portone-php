<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use PHPUnit\Framework\TestCase;

final class OpenApiContractProbeTest extends TestCase
{
    public function test_openapi_probe_reports_operation_signatures(): void
    {
        $process = proc_open(
            [PHP_BINARY, dirname(__DIR__, 2).'/tools/openapi_contract_probe.php', '--check-php'],
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
        self::assertSame(147, $report['operations']);
        self::assertCount(294, $report['methods']);
        self::assertArrayHasKey('getPayments', $report['signatures']);
        self::assertArrayHasKey('expected', $report['signatures']['getPayments']);
        self::assertArrayHasKey('requiredness', $report['signatures']['getPayments']['mismatches']);
        self::assertSame([], $report['signatures']['getPayments']['mismatches']['types']);
    }
}
