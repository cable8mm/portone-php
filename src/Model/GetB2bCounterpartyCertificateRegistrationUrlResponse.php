<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 인증서 등록 URL 조회 응답 정보를 나타내는 모델입니다.
 */
final class GetB2bCounterpartyCertificateRegistrationUrlResponse extends OperationResponse
{
    /**
     * GetB2bCounterpartyCertificateRegistrationUrlResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly string $url) {}

    /**
     * 배열 형식의 API 응답 데이터로 GetB2bCounterpartyCertificateRegistrationUrlResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        if (! is_string($data['url'] ?? null)) {
            throw new \UnexpectedValueException('GetB2bCounterpartyCertificateRegistrationUrlResponse must contain string url.');
        }

        return new self($data['url']);
    }
}
