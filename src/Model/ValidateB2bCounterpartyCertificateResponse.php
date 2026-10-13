<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 인증서 유효성 검증 응답 정보를 나타내는 모델입니다.
 */
final class ValidateB2bCounterpartyCertificateResponse extends OperationResponse
{
    /**
     * ValidateB2bCounterpartyCertificateResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly bool $isValid) {}

    /**
     * 배열 형식의 API 응답 데이터로 ValidateB2bCounterpartyCertificateResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        if (! is_bool($data['isValid'] ?? null)) {
            throw new \UnexpectedValueException('ValidateB2bCounterpartyCertificateResponse must contain boolean isValid.');
        }

        return new self($data['isValid']);
    }
}
