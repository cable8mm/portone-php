<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\LoginViaApiSecretResponse;
use Cable8mm\PortonePhp\Model\RefreshTokenResponse;
use PHPUnit\Framework\TestCase;

final class AuthenticationResponseTest extends TestCase
{
    public function test_login_response_exposes_typed_token_fields(): void
    {
        $response = LoginViaApiSecretResponse::fromArray([
            'accessToken' => 'access',
            'refreshToken' => 'refresh',
            'ignored' => true,
        ]);

        self::assertSame('access', $response->accessToken);
        self::assertSame('refresh', $response->refreshToken);
    }

    public function test_refresh_response_exposes_typed_token_fields(): void
    {
        $response = RefreshTokenResponse::fromArray([
            'accessToken' => 'access',
            'refreshToken' => 'refresh',
        ]);

        self::assertSame('access', $response->accessToken);
        self::assertSame('refresh', $response->refreshToken);
    }

    public function test_token_responses_reject_missing_or_non_string_fields(): void
    {
        foreach ([
            LoginViaApiSecretResponse::class,
            RefreshTokenResponse::class,
        ] as $responseClass) {
            try {
                $responseClass::fromArray(['accessToken' => 'access']);
                self::fail('Expected a missing refresh token to be rejected.');
            } catch (\UnexpectedValueException) {
            }

            $this->expectException(\UnexpectedValueException::class);
            $responseClass::fromArray(['accessToken' => [], 'refreshToken' => 'refresh']);
        }
    }
}
