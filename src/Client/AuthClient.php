<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

final class AuthClient extends AbstractClient
{
    public function loginViaApiSecret(#[\SensitiveParameter] ?string $apiSecret = null): Model\LoginViaApiSecretResponse
    {
        return $this->callOperation('loginViaApiSecret', 'POST', '/login/api-secret', ['apiSecret' => $apiSecret], Model\LoginViaApiSecretResponse::class, true);
    }

    public function loginViaApiSecretAsync(#[\SensitiveParameter] ?string $apiSecret = null): Future
    {
        return $this->callOperationAsync('loginViaApiSecret', 'POST', '/login/api-secret', ['apiSecret' => $apiSecret], Model\LoginViaApiSecretResponse::class, true);
    }

    public function refreshToken(?string $refreshToken = null): Model\RefreshTokenResponse
    {
        return $this->callOperation('refreshToken', 'POST', '/token/refresh', ['refreshToken' => $refreshToken], Model\RefreshTokenResponse::class, true);
    }

    public function refreshTokenAsync(?string $refreshToken = null): Future
    {
        return $this->callOperationAsync('refreshToken', 'POST', '/token/refresh', ['refreshToken' => $refreshToken], Model\RefreshTokenResponse::class, true);
    }
}
