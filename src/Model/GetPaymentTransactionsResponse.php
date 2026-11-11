<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 결제 시도 내역 조회 응답 정보를 나타내는 모델입니다.
 */
final class GetPaymentTransactionsResponse extends OperationResponse
{
    /**
     * GetPaymentTransactionsResponse 객체를 초기화합니다.
     *
     * @param  list<array<string,mixed>>  $items
     * @param  array<string,mixed>  $data  디코딩된 응답 본문입니다.
     */
    public function __construct(public readonly array $items, array $data = [])
    {
        parent::__construct($data);
    }

    /**
     * 배열 형식의 API 응답 데이터로 GetPaymentTransactionsResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        $items = $data['items'] ?? null;
        if (! is_array($items) || ! array_is_list($items) || array_filter($items, 'is_array') !== $items) {
            throw new \UnexpectedValueException('GetPaymentTransactionsResponse must contain a list of transaction objects.');
        }

        return new self($items, data: $data);
    }
}
