<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\ReschedulePlatformContractResponse;
use Cable8mm\PortonePhp\Model\SchedulePlatformPartnerResponse;
use Cable8mm\PortonePhp\Model\UpdatePlatformSettingResponse;
use PHPUnit\Framework\TestCase;

final class PlatformScheduleResponseTest extends TestCase
{
    public function test_platform_schedule_and_update_fields_are_exposed(): void
    {
        self::assertSame(['id' => 'contract-id'], ReschedulePlatformContractResponse::fromArray([
            'scheduledContract' => ['id' => 'contract-id'],
        ])->scheduledContract);
        self::assertSame(['id' => 'partner-id'], SchedulePlatformPartnerResponse::fromArray([
            'scheduledPartner' => ['id' => 'partner-id'],
        ])->scheduledPartner);
        self::assertSame(['enabled' => true], UpdatePlatformSettingResponse::fromArray([
            'setting' => ['enabled' => true],
        ])->setting);
    }

    public function test_platform_schedule_response_rejects_invalid_payloads(): void
    {
        foreach ([
            static fn (): mixed => ReschedulePlatformContractResponse::fromArray([]),
            static fn (): mixed => SchedulePlatformPartnerResponse::fromArray(['scheduledPartner' => 'invalid']),
            static fn (): mixed => UpdatePlatformSettingResponse::fromArray([]),
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
