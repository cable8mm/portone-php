<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 결제 건 다건 조회 성공 응답 정보를 나타내는 모델입니다.
 */
final class GetPaymentsResponse
{
    /**
     * GetPaymentsResponse 객체를 초기화합니다.
     *
     * @param  list<Payment>  $items
     * @param  array<string, mixed>  $page
     */
    public function __construct(
        public readonly array $items,
        public readonly array $page,
    ) {}

    /**
     * 배열 형식의 API 응답 데이터로 GetPaymentsResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): self
    {
        if (! isset($data['items'], $data['page']) || ! is_array($data['items']) || ! is_array($data['page'])) {
            throw new \UnexpectedValueException('GetPaymentsResponse must contain items and page arrays.');
        }

        if (array_filter($data['items'], 'is_array') !== $data['items']) {
            throw new \UnexpectedValueException('GetPaymentsResponse must contain payment objects.');
        }

        return new self(array_map(static fn (array $item): Payment => Payment::fromArray($item), $data['items']), $data['page']);
    }
}
