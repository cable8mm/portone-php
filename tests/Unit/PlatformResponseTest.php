<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Response\PlatformAdditionalFeePolicy;
use Cable8mm\PortonePhp\Response\PlatformPartner;
use Cable8mm\PortonePhp\Response\PlatformTransfer;
use PHPUnit\Framework\TestCase;

final class PlatformResponseTest extends TestCase
{
    public function test_platform_models_validate_openapi_fields(): void
    {
        $policy = PlatformAdditionalFeePolicy::fromArray([
            'id' => 'fee-id', 'graphqlId' => 'graphql-id', 'name' => 'Fee', 'fee' => [],
            'vatPayer' => 'PARTNER', 'isArchived' => false, 'appliedAt' => '2026-10-12T00:00:00Z', 'isForTest' => true,
        ]);
        self::assertSame('fee-id', $policy->id);

        $partner = PlatformPartner::fromArray([
            'id' => 'partner-id', 'graphqlId' => 'graphql-id', 'name' => 'Partner', 'contact' => [],
            'account' => [], 'status' => 'ACTIVE', 'defaultContractId' => 'contract-id', 'tags' => [], 'type' => 'BUSINESS',
            'isArchived' => false, 'appliedAt' => '2026-10-12T00:00:00Z', 'isForTest' => true,
            'userDefinedProperties' => [],
        ]);
        self::assertSame([], $partner->tags);
    }

    public function test_unknown_transfer_type_is_forward_compatible(): void
    {
        $transfer = PlatformTransfer::fromArray(['type' => 'FUTURE', 'id' => 'transfer-id']);

        self::assertFalse($transfer->knownVariant);
        self::assertSame('FUTURE', $transfer->variant);
        self::assertSame('transfer-id', $transfer->data['id']);
    }
}
