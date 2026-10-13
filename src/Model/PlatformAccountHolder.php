<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 예금주 조회 성공 응답 정보를 나타내는 모델입니다.
 */
final class PlatformAccountHolder extends OperationResponse
{
    /**
     * PlatformAccountHolder 객체를 초기화합니다.
     */
    public function __construct(public readonly string $holderName, public readonly string $accountVerificationId) {}

    /**
     * 배열 형식의 API 응답 데이터로 PlatformAccountHolder 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'holderName', self::class),
            self::requireString($data, 'accountVerificationId', self::class),
        );
    }
}
