<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\GetIdentityVerificationsResponse;
use Cable8mm\PortonePhp\Model\IdentityVerification;
use PHPUnit\Framework\TestCase;

final class IdentityVerificationResponseTest extends TestCase
{
    public function test_known_statuses_validate_required_fields_and_keep_payload(): void
    {
        $response = IdentityVerification::fromArray([
            'status' => 'READY',
            'id' => 'verification-id',
            'requestedCustomer' => [],
            'requestedAt' => '2026-10-12T00:00:00Z',
            'updatedAt' => '2026-10-12T00:00:00Z',
            'statusChangedAt' => '2026-10-12T00:00:00Z',
            'version' => '2024-01-01',
        ]);

        self::assertTrue($response->knownVariant);
        self::assertSame('READY', $response->variant);
        self::assertSame('verification-id', $response->data['id']);
    }

    public function test_unknown_status_is_forward_compatible_in_list_responses(): void
    {
        $response = GetIdentityVerificationsResponse::fromArray([
            'items' => [['status' => 'REVIEW', 'id' => 'verification-id']],
            'page' => ['number' => 0, 'size' => 1, 'totalCount' => 1],
        ]);

        self::assertInstanceOf(IdentityVerification::class, $response->items[0]);
        self::assertFalse($response->items[0]->knownVariant);
        self::assertSame('REVIEW', $response->items[0]->variant);
    }

    public function test_known_status_without_required_field_is_rejected(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        IdentityVerification::fromArray(['status' => 'VERIFIED']);
    }
}
