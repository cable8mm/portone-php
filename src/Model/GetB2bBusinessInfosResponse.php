<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 사업자등록 정보 조회 성공 응답을 나타내는 모델입니다.
 */
final class GetB2bBusinessInfosResponse extends OperationResponse
{
    /**
     * GetB2bBusinessInfosResponse 객체를 초기화합니다.
     *
     * @param  list<array<string,mixed>>  $result
     */
    public function __construct(public readonly array $result) {}

    /**
     * 배열 형식의 API 응답 데이터로 GetB2bBusinessInfosResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        $result = $data['result'] ?? null;
        if (! is_array($result) || ! array_is_list($result) || array_filter($result, 'is_array') !== $result) {
            throw new \UnexpectedValueException('GetB2bBusinessInfosResponse must contain a list of result objects.');
        }

        return new self($result);
    }
}
