<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 결제 세션 생성 성공 응답을 나타내는 모델입니다.
 */
final class CreatePaymentSessionResponse extends OperationResponse
{
    /**
     * CreatePaymentSessionResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly string $sessionId, public readonly string $url, public readonly string $expiresAt) {}

    /**
     * 배열 형식의 API 응답 데이터로 CreatePaymentSessionResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'sessionId', self::class),
            self::requireString($data, 'url', self::class),
            self::requireString($data, 'expiresAt', self::class),
        );
    }
}
