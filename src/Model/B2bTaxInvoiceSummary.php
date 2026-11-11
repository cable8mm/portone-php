<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 세금계산서 요약을 나타내는 모델입니다.
 */
final class B2bTaxInvoiceSummary extends OperationResponse
{
    /**
     * B2bTaxInvoiceSummary 객체를 초기화합니다.
     *
     * @param  array<string,mixed>  $data  디코딩된 응답 본문입니다.
     */
    public function __construct(
        public readonly string $id,
        public readonly string $taxationType,
        public readonly string $documentModificationType,
        public readonly ?bool $isDelayed,
        public readonly string $issuanceType,
        public readonly ?string $bulkTaxInvoiceId,
        public readonly ?string $payoutId,
        public readonly int $totalSupplyAmount,
        public readonly int $totalTaxAmount,
        public readonly int $totalAmount,
        public readonly string $purposeType,
        public readonly string $supplierBrn,
        public readonly string $supplierName,
        public readonly string $supplierRepresentativeName,
        public readonly ?string $supplierDocumentKey,
        public readonly ?string $supplierCounterpartyId,
        public readonly string $recipientBrn,
        public readonly string $recipientName,
        public readonly string $recipientRepresentativeName,
        public readonly ?string $recipientDocumentKey,
        public readonly ?string $recipientCounterpartyId,
        public readonly ?string $recipientBusinessStatus,
        public readonly ?string $recipientClosedSuspendedDate,
        public readonly string $writeDate,
        public readonly string $issuanceDueDate,
        public readonly string $status,
        public readonly ?string $draftedAt,
        public readonly ?string $requestedAt,
        public readonly ?string $issuedAt,
        public readonly ?string $openedAt,
        public readonly string $statusUpdatedAt,
        public readonly ?string $ntsSentAt,
        public readonly ?string $ntsApprovalNumber,
        public readonly ?string $ntsResult,
        public readonly ?string $ntsResultReceivedAt,
        public readonly ?string $ntsResultCode,
        public readonly ?string $memo,
        public readonly array $items,
        array $data = [],
    ) {
        parent::__construct($data);
    }

    /**
     * 배열 형식의 API 응답 데이터로 B2bTaxInvoiceSummary 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'id', self::class),
            self::requireString($data, 'taxationType', self::class),
            self::requireString($data, 'documentModificationType', self::class),
            self::optionalNonNullableBool($data, 'isDelayed', self::class),
            self::requireString($data, 'issuanceType', self::class),
            self::optionalNonNullableString($data, 'bulkTaxInvoiceId', self::class),
            self::optionalNonNullableString($data, 'payoutId', self::class),
            self::requireInt($data, 'totalSupplyAmount', self::class),
            self::requireInt($data, 'totalTaxAmount', self::class),
            self::requireInt($data, 'totalAmount', self::class),
            self::requireString($data, 'purposeType', self::class),
            self::requireString($data, 'supplierBrn', self::class),
            self::requireString($data, 'supplierName', self::class),
            self::requireString($data, 'supplierRepresentativeName', self::class),
            self::optionalNonNullableString($data, 'supplierDocumentKey', self::class),
            self::optionalNonNullableString($data, 'supplierCounterpartyId', self::class),
            self::requireString($data, 'recipientBrn', self::class),
            self::requireString($data, 'recipientName', self::class),
            self::requireString($data, 'recipientRepresentativeName', self::class),
            self::optionalNonNullableString($data, 'recipientDocumentKey', self::class),
            self::optionalNonNullableString($data, 'recipientCounterpartyId', self::class),
            self::optionalNonNullableString($data, 'recipientBusinessStatus', self::class),
            self::optionalNonNullableString($data, 'recipientClosedSuspendedDate', self::class),
            self::requireString($data, 'writeDate', self::class),
            self::requireString($data, 'issuanceDueDate', self::class),
            self::requireString($data, 'status', self::class),
            self::optionalNonNullableString($data, 'draftedAt', self::class),
            self::optionalNonNullableString($data, 'requestedAt', self::class),
            self::optionalNonNullableString($data, 'issuedAt', self::class),
            self::optionalNonNullableString($data, 'openedAt', self::class),
            self::requireString($data, 'statusUpdatedAt', self::class),
            self::optionalNonNullableString($data, 'ntsSentAt', self::class),
            self::optionalNonNullableString($data, 'ntsApprovalNumber', self::class),
            self::optionalNonNullableString($data, 'ntsResult', self::class),
            self::optionalNonNullableString($data, 'ntsResultReceivedAt', self::class),
            self::optionalNonNullableString($data, 'ntsResultCode', self::class),
            self::optionalNonNullableString($data, 'memo', self::class),
            self::requireObjectList($data, 'items', self::class),
            data: $data,
        );
    }
}
