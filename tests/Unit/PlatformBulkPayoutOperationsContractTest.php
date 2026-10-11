<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\BulkAccountTransferClient;
use Cable8mm\PortonePhp\BulkPayoutClient;
use Cable8mm\PortonePhp\PayoutClient;
use PHPUnit\Framework\TestCase;

final class PlatformBulkPayoutOperationsContractTest extends TestCase
{
    /** @var array<string,class-string> */
    private const CLIENTS = [
        'BulkAccountTransferClient' => BulkAccountTransferClient::class,
        'BulkPayoutClient' => BulkPayoutClient::class,
        'PayoutClient' => PayoutClient::class,
    ];

    public function test_platform_bulk_and_payout_clients_match_the_recorded_jvm_contract(): void
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
