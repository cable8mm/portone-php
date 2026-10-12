<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\ArchivePlatformContractResponse;
use Cable8mm\PortonePhp\Model\CreatePlatformPartnerResponse;
use Cable8mm\PortonePhp\Model\RecoverPlatformAdditionalFeePolicyResponse;
use PHPUnit\Framework\TestCase;

final class PlatformPolicyResponseTest extends TestCase
{
    public function test_platform_object_envelopes_expose_their_payloads(): void
    {
        self::assertSame(['id' => 'contract-id'], ArchivePlatformContractResponse::fromArray([
            'contract' => ['id' => 'contract-id'],
        ])->contract);
        self::assertSame(['id' => 'partner-id'], CreatePlatformPartnerResponse::fromArray([
            'partner' => ['id' => 'partner-id'],
        ])->partner);
        self::assertSame(['id' => 'policy-id'], RecoverPlatformAdditionalFeePolicyResponse::fromArray([
            'additionalFeePolicy' => ['id' => 'policy-id'],
        ])->additionalFeePolicy);
    }

    public function test_platform_object_envelopes_reject_missing_payloads(): void
    {
        foreach ([
            static fn (): mixed => ArchivePlatformContractResponse::fromArray([]),
            static fn (): mixed => CreatePlatformPartnerResponse::fromArray(['partner' => 'invalid']),
            static fn (): mixed => RecoverPlatformAdditionalFeePolicyResponse::fromArray([]),
        ] as $case) {
            try {
                $case();
                self::fail('Expected an invalid Platform response envelope to be rejected.');
            } catch (\UnexpectedValueException) {
                self::assertTrue(true);
            }
        }
    }
}
