<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class AuthClient extends AbstractClient
{
    public function loginViaApiSecret(mixed $apiSecret = null): Response\LoginViaApiSecretResponse
    {
        return $this->callOperation('loginViaApiSecret', 'POST', '/login/api-secret', ['apiSecret' => $apiSecret], Response\LoginViaApiSecretResponse::class, true);
    }

    public function loginViaApiSecretAsync(mixed $apiSecret = null): Future
    {
        return $this->callOperationAsync('loginViaApiSecret', 'POST', '/login/api-secret', ['apiSecret' => $apiSecret], Response\LoginViaApiSecretResponse::class, true);
    }

    public function refreshToken(mixed $refreshToken = null): Response\RefreshTokenResponse
    {
        return $this->callOperation('refreshToken', 'POST', '/token/refresh', ['refreshToken' => $refreshToken], Response\RefreshTokenResponse::class, true);
    }

    public function refreshTokenAsync(mixed $refreshToken = null): Future
    {
        return $this->callOperationAsync('refreshToken', 'POST', '/token/refresh', ['refreshToken' => $refreshToken], Response\RefreshTokenResponse::class, true);
    }
}
