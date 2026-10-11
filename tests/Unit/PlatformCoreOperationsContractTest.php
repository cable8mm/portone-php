<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\AccountClient;
use Cable8mm\PortonePhp\AccountTransferClient;
use Cable8mm\PortonePhp\CompanyClient;
use Cable8mm\PortonePhp\PlatformClient;
use PHPUnit\Framework\TestCase;

final class PlatformCoreOperationsContractTest extends TestCase
{
    /** @var array<string,class-string> */
    private const CLIENTS = [
        'PlatformClient' => PlatformClient::class,
        'CompanyClient' => CompanyClient::class,
        'AccountClient' => AccountClient::class,
        'AccountTransferClient' => AccountTransferClient::class,
    ];

    public function test_platform_core_clients_match_the_recorded_jvm_contract(): void
    {
        $contract = json_decode(
            (string) file_get_contents(__DIR__.'/../fixtures/jvm-v0.24.0-contract.json'),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );

        foreach (self::CLIENTS as $clientName => $clientClass) {
            $reflection = new \ReflectionClass($clientClass);
            foreach ($contract['clients'][$clientName]['operations'] as $operation => $definition) {
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
}
