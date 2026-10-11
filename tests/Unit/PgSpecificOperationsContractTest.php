<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\PgSpecificClient;
use PHPUnit\Framework\TestCase;

final class PgSpecificOperationsContractTest extends TestCase
{
    public function test_pg_specific_operations_match_the_recorded_jvm_contract(): void
    {
        $contract = json_decode(
            (string) file_get_contents(__DIR__.'/../fixtures/jvm-v0.24.0-contract.json'),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        $reflection = new \ReflectionClass(PgSpecificClient::class);

        foreach ($contract['clients']['PgSpecificClient']['operations'] as $operation => $definition) {
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
