<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 체크아웃 프로필 평가 성공 응답을 나타내는 모델입니다.
 */
final class EvaluateCheckoutProfileResponse extends OperationResponse
{
    /**
     * EvaluateCheckoutProfileResponse 객체를 초기화합니다.
     *
     * @param  list<EvaluatedCheckoutMethod>|null  $methods
     */
    public function __construct(public readonly ?array $methods) {}

    /**
     * 배열 형식의 API 응답 데이터로 EvaluateCheckoutProfileResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        $methods = self::optionalNonNullableObjectList($data, 'methods', self::class);

        return new self($methods === null ? null : self::mapObjectList(
            $methods,
            static fn (array $method): EvaluatedCheckoutMethod => EvaluatedCheckoutMethod::fromArray($method),
        ));
    }
}
