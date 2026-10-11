<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\AdditionalFeatureClient;
use Cable8mm\PortonePhp\BillingKeyClient;
use Cable8mm\PortonePhp\CashReceiptClient;
use Cable8mm\PortonePhp\PaymentClient;
use Cable8mm\PortonePhp\PaymentScheduleClient;
use Cable8mm\PortonePhp\PromotionClient;
use PHPUnit\Framework\TestCase;

final class PaymentOperationsContractTest extends TestCase
{
    public function test_payment_clients_expose_the_recorded_sync_and_async_operations(): void
    {
        $contract = json_decode(
            (string) file_get_contents(__DIR__.'/../fixtures/jvm-v0.24.0-contract.json'),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        $classes = [
            'PaymentClient' => PaymentClient::class,
            'BillingKeyClient' => BillingKeyClient::class,
            'CashReceiptClient' => CashReceiptClient::class,
            'AdditionalFeatureClient' => AdditionalFeatureClient::class,
            'PaymentScheduleClient' => PaymentScheduleClient::class,
            'PromotionClient' => PromotionClient::class,
        ];

        foreach ($classes as $name => $class) {
            $reflection = new \ReflectionClass($class);
            foreach ($contract['clients'][$name]['operations'] as $operation => $definition) {
                self::assertTrue($reflection->hasMethod($operation), "$name::$operation is missing.");
                self::assertTrue($reflection->hasMethod($operation.'Async'), "$name::{$operation}Async is missing.");
                self::assertSame(
                    $definition['parameters'],
                    array_map(
                        static fn (\ReflectionParameter $parameter): string => $parameter->getName(),
                        $reflection->getMethod($operation)->getParameters(),
                    ),
                    "$name::$operation parameter names differ.",
                );
                self::assertSame(
                    $definition['parameters'],
                    array_map(
                        static fn (\ReflectionParameter $parameter): string => $parameter->getName(),
                        $reflection->getMethod($operation.'Async')->getParameters(),
                    ),
                    "$name::{$operation}Async parameter names differ.",
                );
            }
        }
    }
}
