<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 세금계산서 다건 조회 성공 응답을 나타내는 모델입니다.
 */
final class GetB2bTaxInvoicesResponse extends OperationResponse
{
    /**
     * GetB2bTaxInvoicesResponse 객체를 초기화합니다.
     *
     * @param  list<B2bTaxInvoice>  $items
     * @param  array<string, mixed>  $page
     */
    public function __construct(public readonly array $items, public readonly array $page) {}

    /**
     * 배열 형식의 API 응답 데이터로 GetB2bTaxInvoicesResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        $items = $data['items'] ?? null;
        if (! is_array($items) || ! array_is_list($items) || array_filter($items, 'is_array') !== $items || ! is_array($data['page'] ?? null)) {
            throw new \UnexpectedValueException('GetB2bTaxInvoicesResponse must contain items and page arrays.');
        }

        return new self(array_map(static fn (array $item): B2bTaxInvoice => B2bTaxInvoice::fromArray($item), $items), $data['page']);
    }
}
