<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 토큰 재발급 성공 응답을 나타내는 모델입니다.
 */
final class RefreshTokenResponse extends OperationResponse
{
    /**
     * RefreshTokenResponse 객체를 초기화합니다.
     */
    public function __construct(
        public readonly string $accessToken,
        public readonly string $refreshToken,
    ) {}

    /**
     * 배열 형식의 API 응답 데이터로 RefreshTokenResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        if (! is_string($data['accessToken'] ?? null) || ! is_string($data['refreshToken'] ?? null)) {
            throw new \UnexpectedValueException('RefreshTokenResponse must contain string accessToken and refreshToken fields.');
        }

        return new self($data['accessToken'], $data['refreshToken']);
    }
}
