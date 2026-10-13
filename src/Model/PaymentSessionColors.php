<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 체크아웃 페이지 색 설정을 나타내는 모델입니다.
 */
final class PaymentSessionColors
{
    /**
     * PaymentSessionColors 객체를 초기화합니다.
     */
    public function __construct(
        public readonly ?string $primary,
        public readonly ?string $primaryHover,
        public readonly ?string $primaryLight,
    ) {}

    /**
     * 배열 형식의 API 응답 데이터로 PaymentSessionColors 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            OperationResponse::optionalNonNullableString($data, 'primary', self::class),
            OperationResponse::optionalNonNullableString($data, 'primaryHover', self::class),
            OperationResponse::optionalNonNullableString($data, 'primaryLight', self::class),
        );
    }
}
