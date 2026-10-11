<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\ReconciliationClient;
use PHPUnit\Framework\TestCase;

final class ReconciliationOperationsContractTest extends TestCase
{
    public function test_reconciliation_operations_match_the_recorded_jvm_contract(): void
    {
        $contract = json_decode(
            (string) file_get_contents(__DIR__.'/../fixtures/jvm-v0.24.0-contract.json'),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        $reflection = new \ReflectionClass(ReconciliationClient::class);

        foreach ($contract['clients']['ReconciliationClient']['operations'] as $operation => $definition) {
            self::assertTrue($reflection->hasMethod($operation));
            self::assertTrue($reflection->hasMethod($operation.'Async'));
            self::assertSame(
                $definition['parameters'],
                array_map(
                    static fn (\ReflectionParameter $parameter): string => $parameter->getName(),
                    $reflection->getMethod($operation)->getParameters(),
                ),
            );
            self::assertSame(
                $definition['parameters'],
                array_map(
                    static fn (\ReflectionParameter $parameter): string => $parameter->getName(),
                    $reflection->getMethod($operation.'Async')->getParameters(),
                ),
            );
        }
    }
}
