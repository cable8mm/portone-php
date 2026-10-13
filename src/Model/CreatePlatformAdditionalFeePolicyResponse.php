<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 플랫폼 생성 성공 응답 정보를 나타내는 모델입니다.
 */
final class CreatePlatformAdditionalFeePolicyResponse extends OperationResponse
{
    /**
     * CreatePlatformAdditionalFeePolicyResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly array $additionalFeePolicy) {}

    /**
     * 배열 형식의 API 응답 데이터로 CreatePlatformAdditionalFeePolicyResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['additionalFeePolicy'] ?? null)) {
            throw new \UnexpectedValueException('CreatePlatformAdditionalFeePolicyResponse must contain an additionalFeePolicy object.');
        }

        return new self($data['additionalFeePolicy']);
    }
}
