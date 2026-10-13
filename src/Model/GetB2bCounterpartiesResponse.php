<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 거래처 검색 성공 응답을 나타내는 모델입니다.
 */
final class GetB2bCounterpartiesResponse extends OperationResponse
{
    /**
     * GetB2bCounterpartiesResponse 객체를 초기화합니다.
     *
     * @param  list<B2bCounterparty>  $items
     * @param  array<string, mixed>  $page
     */
    public function __construct(public readonly array $items, public readonly array $page) {}

    /**
     * 배열 형식의 API 응답 데이터로 GetB2bCounterpartiesResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        $items = $data['items'] ?? null;
        if (! is_array($items) || ! array_is_list($items) || array_filter($items, 'is_array') !== $items || ! is_array($data['page'] ?? null)) {
            throw new \UnexpectedValueException('GetB2bCounterpartiesResponse must contain items and page arrays.');
        }

        return new self(array_map(static fn (array $item): B2bCounterparty => B2bCounterparty::fromArray($item), $items), $data['page']);
    }
}
