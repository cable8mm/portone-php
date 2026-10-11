<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\IdentityVerificationClient;
use PHPUnit\Framework\TestCase;

final class IdentityVerificationOperationsContractTest extends TestCase
{
    public function test_identity_verification_operations_are_exposed(): void
    {
        $contract = json_decode(
            (string) file_get_contents(__DIR__.'/../fixtures/jvm-v0.24.0-contract.json'),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        $reflection = new \ReflectionClass(IdentityVerificationClient::class);

        foreach ($contract['clients']['IdentityVerificationClient']['operations'] as $operation => $definition) {
            self::assertTrue($reflection->hasMethod($operation));
            self::assertTrue($reflection->hasMethod($operation.'Async'));
        }
    }
}
