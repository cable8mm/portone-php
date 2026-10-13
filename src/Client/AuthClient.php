<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 인증 API 작업을 제공합니다.
 */
final class AuthClient extends AbstractClient
{
    /**
     * API secret 를 사용한 토큰 발급 기능입니다.
     * API secret 를 통해 API 인증에 사용할 토큰을 가져옵니다.
     */
    public function loginViaApiSecret(#[\SensitiveParameter] ?string $apiSecret = null): Model\LoginViaApiSecretResponse
    {
        return $this->callOperation('loginViaApiSecret', 'POST', '/login/api-secret', ['apiSecret' => $apiSecret], Model\LoginViaApiSecretResponse::class, true);
    }

    /**
     * API secret 를 사용한 토큰 발급 기능입니다.
     * API secret 를 통해 API 인증에 사용할 토큰을 가져옵니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function loginViaApiSecretAsync(#[\SensitiveParameter] ?string $apiSecret = null): Future
    {
        return $this->callOperationAsync('loginViaApiSecret', 'POST', '/login/api-secret', ['apiSecret' => $apiSecret], Model\LoginViaApiSecretResponse::class, true);
    }

    /**
     * 토큰 갱신 기능입니다.
     * 리프레시 토큰을 사용해 유효기간이 연장된 새로운 토큰을 재발급합니다.
     */
    public function refreshToken(?string $refreshToken = null): Model\RefreshTokenResponse
    {
        return $this->callOperation('refreshToken', 'POST', '/token/refresh', ['refreshToken' => $refreshToken], Model\RefreshTokenResponse::class, true);
    }

    /**
     * 토큰 갱신 기능입니다.
     * 리프레시 토큰을 사용해 유효기간이 연장된 새로운 토큰을 재발급합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function refreshTokenAsync(?string $refreshToken = null): Future
    {
        return $this->callOperationAsync('refreshToken', 'POST', '/token/refresh', ['refreshToken' => $refreshToken], Model\RefreshTokenResponse::class, true);
    }
}
