<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 세금계산서 첨부파일 목록 조회 성공 응답을 나타내는 모델입니다.
 */
final class GetB2bTaxInvoiceAttachmentsResponse extends OperationResponse
{
    /**
     * GetB2bTaxInvoiceAttachmentsResponse 객체를 초기화합니다.
     *
     * @param  list<array<string,mixed>>  $attachments
     */
    public function __construct(public readonly array $attachments) {}

    /**
     * 배열 형식의 API 응답 데이터로 GetB2bTaxInvoiceAttachmentsResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        $attachments = $data['attachments'] ?? null;
        if (! is_array($attachments) || ! array_is_list($attachments) || array_filter($attachments, 'is_array') !== $attachments) {
            throw new \UnexpectedValueException('GetB2bTaxInvoiceAttachmentsResponse must contain a list of attachment objects.');
        }

        return new self($attachments);
    }
}
