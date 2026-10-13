<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 세금계산서 발행 승인 응답을 나타내는 모델입니다.
 */
final class IssueB2bTaxInvoiceResponse extends OperationResponse
{
    /**
     * IssueB2bTaxInvoiceResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly array $taxInvoice) {}

    /**
     * 배열 형식의 API 응답 데이터로 IssueB2bTaxInvoiceResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['taxInvoice'] ?? null)) {
            throw new \UnexpectedValueException('IssueB2bTaxInvoiceResponse must contain a taxInvoice object.');
        }

        return new self($data['taxInvoice']);
    }
}
