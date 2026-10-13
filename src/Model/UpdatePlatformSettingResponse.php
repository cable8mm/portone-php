<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 플랫폼 설정 업데이트 결과를 나타내는 모델입니다.
 */
final class UpdatePlatformSettingResponse extends OperationResponse
{
    /**
     * UpdatePlatformSettingResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly array $setting) {}

    /**
     * 배열 형식의 API 응답 데이터로 UpdatePlatformSettingResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['setting'] ?? null)) {
            throw new \UnexpectedValueException('UpdatePlatformSettingResponse must contain a setting object.');
        }

        return new self($data['setting']);
    }
}
