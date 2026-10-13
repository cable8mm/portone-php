<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * B2B 세금계산서 API 작업을 제공합니다.
 */
final class TaxInvoiceClient extends AbstractClient
{
    /**
     * 세금계산서 파일 첨부 기능입니다.
     * 세금계산서에 파일을 첨부합니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  string|null  $fileId  파일 아이디
     */
    public function attachB2bTaxInvoiceFile(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $fileId = null): void
    {
        $this->callUnitOperationWithQueryAndBody('attachB2bTaxInvoiceFile', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/attach-file', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['fileId' => $fileId]);
    }

    /**
     * 세금계산서 파일 첨부 기능입니다.
     * 세금계산서에 파일을 첨부합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  string|null  $fileId  파일 아이디
     */
    public function attachB2bTaxInvoiceFileAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $fileId = null): Future
    {
        return $this->callUnitOperationWithQueryAndBodyAsync('attachB2bTaxInvoiceFile', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/attach-file', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['fileId' => $fileId]);
    }

    /**
     * 세금계산서 취소 (공급자에 의한 취소) 기능입니다.
     * 발행 완료된 세금계산서를 공급자가 국세청 전송 전에 취소합니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  string|null  $memo  메모
     */
    public function cancelB2bTaxInvoiceIssuance(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null): Model\CancelB2bTaxInvoiceIssuanceResponse
    {
        return $this->callOperationWithQueryAndBody('cancelB2bTaxInvoiceIssuance', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/cancel-issuance', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo], Model\CancelB2bTaxInvoiceIssuanceResponse::class);
    }

    /**
     * 세금계산서 취소 (공급자에 의한 취소) 기능입니다.
     * 발행 완료된 세금계산서를 공급자가 국세청 전송 전에 취소합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  string|null  $memo  메모
     */
    public function cancelB2bTaxInvoiceIssuanceAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('cancelB2bTaxInvoiceIssuance', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/cancel-issuance', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo], Model\CancelB2bTaxInvoiceIssuanceResponse::class);
    }

    /**
     * 세금계산서 역발행 요청 취소 (공급받는자에 의한 취소) 기능입니다.
     * 공급자가 세금계산서 발행을 승인하기 전에 공급받는자가 해당 역발행 요청을 취소합니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  string|null  $memo  메모
     */
    public function cancelB2bTaxInvoiceRequest(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null): Model\CancelB2bTaxInvoiceRequestResponse
    {
        return $this->callOperationWithQueryAndBody('cancelB2bTaxInvoiceRequest', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/cancel-request', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo], Model\CancelB2bTaxInvoiceRequestResponse::class);
    }

    /**
     * 세금계산서 역발행 요청 취소 (공급받는자에 의한 취소) 기능입니다.
     * 공급자가 세금계산서 발행을 승인하기 전에 공급받는자가 해당 역발행 요청을 취소합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  string|null  $memo  메모
     */
    public function cancelB2bTaxInvoiceRequestAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('cancelB2bTaxInvoiceRequest', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/cancel-request', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo], Model\CancelB2bTaxInvoiceRequestResponse::class);
    }

    /**
     * 파일 업로드 URL 생성 기능입니다.
     * S3 파일 업로드를 위한 URL을 생성합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  string|null  $fileName  파일 이름
     */
    public function createB2bFileUploadUrl(?bool $test = null, ?string $fileName = null): Model\CreateB2bFileUploadUrlPayload
    {
        return $this->callOperationWithQueryAndBody('createB2bFileUploadUrl', 'POST', '/b2b/file-upload-url', ['test' => $test], ['fileName' => $fileName], Model\CreateB2bFileUploadUrlPayload::class);
    }

    /**
     * 파일 업로드 URL 생성 기능입니다.
     * S3 파일 업로드를 위한 URL을 생성합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  string|null  $fileName  파일 이름
     */
    public function createB2bFileUploadUrlAsync(?bool $test = null, ?string $fileName = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createB2bFileUploadUrl', 'POST', '/b2b/file-upload-url', ['test' => $test], ['fileName' => $fileName], Model\CreateB2bFileUploadUrlPayload::class);
    }

    /**
     * 세금계산서 삭제 기능입니다.
     * 세금계산서를 삭제합니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function deleteB2bTaxInvoice(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Model\DeleteB2bTaxInvoiceResponse
    {
        return $this->callOperation('deleteB2bTaxInvoice', 'DELETE', '/b2b/tax-invoices/{taxInvoiceKey}', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Model\DeleteB2bTaxInvoiceResponse::class, false);
    }

    /**
     * 세금계산서 삭제 기능입니다.
     * 세금계산서를 삭제합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function deleteB2bTaxInvoiceAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('deleteB2bTaxInvoice', 'DELETE', '/b2b/tax-invoices/{taxInvoiceKey}', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Model\DeleteB2bTaxInvoiceResponse::class, false);
    }

    /**
     * 세금계산서 첨부파일 삭제 기능입니다.
     * 세금계산서 첨부파일을 삭제합니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $attachmentId  첨부파일 아이디
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function deleteB2bTaxInvoiceAttachment(?string $taxInvoiceKey = null, ?string $attachmentId = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): void
    {
        $this->callUnitOperationWithQuery('deleteB2bTaxInvoiceAttachment', 'DELETE', '/b2b/tax-invoices/{taxInvoiceKey}/attachments/{attachmentId}', ['taxInvoiceKey' => $taxInvoiceKey, 'attachmentId' => $attachmentId, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test]);
    }

    /**
     * 세금계산서 첨부파일 삭제 기능입니다.
     * 세금계산서 첨부파일을 삭제합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $attachmentId  첨부파일 아이디
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function deleteB2bTaxInvoiceAttachmentAsync(?string $taxInvoiceKey = null, ?string $attachmentId = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callUnitOperationWithQueryAsync('deleteB2bTaxInvoiceAttachment', 'DELETE', '/b2b/tax-invoices/{taxInvoiceKey}/attachments/{attachmentId}', ['taxInvoiceKey' => $taxInvoiceKey, 'attachmentId' => $attachmentId, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test]);
    }

    /**
     * 세금계산서 엑셀 파일(csv) 다운로드 기능입니다.
     * 세금계산서를 엑셀 파일(csv)로 다운로드합니다.
     *
     * @param  array<string, mixed>|null  $filter  세금계산서 다건 조회 필터
     * @param  array<string, mixed>|null  $fields  다운로드 할 시트 컬럼
     * @param  bool|null  $test  테스트 모드 여부. true이면 테스트 모드로 실행되며, false이거나 주어지지 않으면 테스트 모드를 사용하지 않습니다.
     * @param  array<string, mixed>|null  $sort  세금계산서 다건 조회 시 정렬 조건: 미입력 시 상태 업데이트 일시 내림차순 정렬됩니다.
     */
    public function downloadB2bTaxInvoicesSheet(?array $filter = null, ?array $fields = null, ?bool $test = null, ?array $sort = null): string
    {
        return $this->callStringOperationWithQueryRequestBody('downloadB2bTaxInvoicesSheet', 'GET', '/b2b/tax-invoices-sheet', [], ['filter' => $filter, 'fields' => $fields, 'test' => $test, 'sort' => $sort]);
    }

    /**
     * 세금계산서 엑셀 파일(csv) 다운로드 기능입니다.
     * 세금계산서를 엑셀 파일(csv)로 다운로드합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  array<string, mixed>|null  $filter  세금계산서 다건 조회 필터
     * @param  array<string, mixed>|null  $fields  다운로드 할 시트 컬럼
     * @param  bool|null  $test  테스트 모드 여부. true이면 테스트 모드로 실행되며, false이거나 주어지지 않으면 테스트 모드를 사용하지 않습니다.
     * @param  array<string, mixed>|null  $sort  세금계산서 다건 조회 시 정렬 조건: 미입력 시 상태 업데이트 일시 내림차순 정렬됩니다.
     */
    public function downloadB2bTaxInvoicesSheetAsync(?array $filter = null, ?array $fields = null, ?bool $test = null, ?array $sort = null): Future
    {
        return $this->callStringOperationWithQueryRequestBodyAsync('downloadB2bTaxInvoicesSheet', 'GET', '/b2b/tax-invoices-sheet', [], ['filter' => $filter, 'fields' => $fields, 'test' => $test, 'sort' => $sort]);
    }

    /**
     * 세금계산서 임시 저장 기능입니다.
     * 세금계산서 임시 저장을 요청합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  array<string, mixed>|null  $taxInvoice  세금계산서 생성 요청 정보
     * @param  array<string, mixed>|null  $modification  수정 세금계산서 생성 입력 정보
     * @param  string|null  $memo  메모
     * @param  bool|null  $createRecipientCounterparty  공급받는자 거래처 생성 여부: true인 경우 공급받는자 정보로 거래처를 자동 생성합니다.
     */
    public function draftB2bTaxInvoice(?bool $test = null, ?array $taxInvoice = null, ?array $modification = null, ?string $memo = null, ?bool $createRecipientCounterparty = null): Model\DraftB2bTaxInvoiceResponse
    {
        return $this->callOperationWithQueryAndBody('draftB2bTaxInvoice', 'POST', '/b2b/tax-invoices/draft', ['test' => $test], ['taxInvoice' => $taxInvoice, 'modification' => $modification, 'memo' => $memo, 'createRecipientCounterparty' => $createRecipientCounterparty], Model\DraftB2bTaxInvoiceResponse::class);
    }

    /**
     * 세금계산서 임시 저장 기능입니다.
     * 세금계산서 임시 저장을 요청합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  array<string, mixed>|null  $taxInvoice  세금계산서 생성 요청 정보
     * @param  array<string, mixed>|null  $modification  수정 세금계산서 생성 입력 정보
     * @param  string|null  $memo  메모
     * @param  bool|null  $createRecipientCounterparty  공급받는자 거래처 생성 여부: true인 경우 공급받는자 정보로 거래처를 자동 생성합니다.
     */
    public function draftB2bTaxInvoiceAsync(?bool $test = null, ?array $taxInvoice = null, ?array $modification = null, ?string $memo = null, ?bool $createRecipientCounterparty = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('draftB2bTaxInvoice', 'POST', '/b2b/tax-invoices/draft', ['test' => $test], ['taxInvoice' => $taxInvoice, 'modification' => $modification, 'memo' => $memo, 'createRecipientCounterparty' => $createRecipientCounterparty], Model\DraftB2bTaxInvoiceResponse::class);
    }

    /**
     * 일괄 세금계산서 조회 기능입니다.
     * 등록된 일괄 세금계산서를 일괄 세금계산서 아이디로 조회합니다.
     *
     * @param  string|null  $bulkTaxInvoiceId  일괄 세금계산서 아이디
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function getB2bBulkTaxInvoice(?string $bulkTaxInvoiceId = null, ?bool $test = null): Model\B2bBulkTaxInvoice
    {
        return $this->callOperation('getB2bBulkTaxInvoice', 'GET', '/b2b/bulk-tax-invoices/{bulkTaxInvoiceId}', ['bulkTaxInvoiceId' => $bulkTaxInvoiceId, 'test' => $test], Model\B2bBulkTaxInvoice::class, false);
    }

    /**
     * 일괄 세금계산서 조회 기능입니다.
     * 등록된 일괄 세금계산서를 일괄 세금계산서 아이디로 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $bulkTaxInvoiceId  일괄 세금계산서 아이디
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function getB2bBulkTaxInvoiceAsync(?string $bulkTaxInvoiceId = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getB2bBulkTaxInvoice', 'GET', '/b2b/bulk-tax-invoices/{bulkTaxInvoiceId}', ['bulkTaxInvoiceId' => $bulkTaxInvoiceId, 'test' => $test], Model\B2bBulkTaxInvoice::class, false);
    }

    /**
     * 세금 계산서 조회 기능입니다.
     * 등록된 세금 계산서를 세금계산서 아이디로 조회합니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function getB2bTaxInvoice(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Model\B2bTaxInvoice
    {
        return $this->callOperation('getB2bTaxInvoice', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Model\B2bTaxInvoice::class, false);
    }

    /**
     * 세금 계산서 조회 기능입니다.
     * 등록된 세금 계산서를 세금계산서 아이디로 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function getB2bTaxInvoiceAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getB2bTaxInvoice', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Model\B2bTaxInvoice::class, false);
    }

    /**
     * 세금계산서 첨부파일 목록 조회 기능입니다.
     * 세금계산서에 첨부된 파일 목록을 조회합니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function getB2bTaxInvoiceAttachments(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Model\GetB2bTaxInvoiceAttachmentsResponse
    {
        return $this->callOperation('getB2bTaxInvoiceAttachments', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/attachments', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Model\GetB2bTaxInvoiceAttachmentsResponse::class, false);
    }

    /**
     * 세금계산서 첨부파일 목록 조회 기능입니다.
     * 세금계산서에 첨부된 파일 목록을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function getB2bTaxInvoiceAttachmentsAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getB2bTaxInvoiceAttachments', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/attachments', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Model\GetB2bTaxInvoiceAttachmentsResponse::class, false);
    }

    /**
     * 세금 계산서 PDF 다운로드 URL 조회 기능입니다.
     * 등록된 세금 계산서 PDF 다운로드 URL을 공급자 혹은 공급받는자 문서번호로 조회합니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function getB2bTaxInvoicePdfDownloadUrl(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Model\GetB2bTaxInvoicePdfDownloadUrlResponse
    {
        return $this->callOperation('getB2bTaxInvoicePdfDownloadUrl', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/pdf-download-url', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Model\GetB2bTaxInvoicePdfDownloadUrlResponse::class, false);
    }

    /**
     * 세금 계산서 PDF 다운로드 URL 조회 기능입니다.
     * 등록된 세금 계산서 PDF 다운로드 URL을 공급자 혹은 공급받는자 문서번호로 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function getB2bTaxInvoicePdfDownloadUrlAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getB2bTaxInvoicePdfDownloadUrl', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/pdf-download-url', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Model\GetB2bTaxInvoicePdfDownloadUrlResponse::class, false);
    }

    /**
     * 세금 계산서 팝업 URL 조회 기능입니다.
     * 등록된 세금 계산서 팝업 URL을 공급자 혹은 공급받는자 문서번호로 조회합니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $includeMenu  메뉴 포함 여부: 팝업 URL에 메뉴 레이아웃을 포함 여부를 결정합니다. 기본 값은 true입니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function getB2bTaxInvoicePopupUrl(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $includeMenu = null, ?bool $test = null): Model\GetB2bTaxInvoicePopupUrlResponse
    {
        return $this->callOperation('getB2bTaxInvoicePopupUrl', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/popup-url', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'includeMenu' => $includeMenu, 'test' => $test], Model\GetB2bTaxInvoicePopupUrlResponse::class, false);
    }

    /**
     * 세금 계산서 팝업 URL 조회 기능입니다.
     * 등록된 세금 계산서 팝업 URL을 공급자 혹은 공급받는자 문서번호로 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $includeMenu  메뉴 포함 여부: 팝업 URL에 메뉴 레이아웃을 포함 여부를 결정합니다. 기본 값은 true입니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function getB2bTaxInvoicePopupUrlAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $includeMenu = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getB2bTaxInvoicePopupUrl', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/popup-url', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'includeMenu' => $includeMenu, 'test' => $test], Model\GetB2bTaxInvoicePopupUrlResponse::class, false);
    }

    /**
     * 세금 계산서 프린트 URL 조회 기능입니다.
     * 등록된 세금 계산서 프린트 URL을 공급자 혹은 공급받는자 문서번호로 조회합니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function getB2bTaxInvoicePrintUrl(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Model\GetB2bTaxInvoicePrintUrlResponse
    {
        return $this->callOperation('getB2bTaxInvoicePrintUrl', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/print-url', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Model\GetB2bTaxInvoicePrintUrlResponse::class, false);
    }

    /**
     * 세금 계산서 프린트 URL 조회 기능입니다.
     * 등록된 세금 계산서 프린트 URL을 공급자 혹은 공급받는자 문서번호로 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function getB2bTaxInvoicePrintUrlAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getB2bTaxInvoicePrintUrl', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/print-url', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Model\GetB2bTaxInvoicePrintUrlResponse::class, false);
    }

    /**
     * 세금 계산서 다건조회 기능입니다.
     * 조회 기간 내 등록된 세금 계산서를 다건 조회합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  int|null  $pageNumber  0부터 시작하는 페이지 번호. 기본 값은 0.
     * @param  int|null  $pageSize  페이지 크기: 각 페이지 당 포함할 객체 수. 기본 값은 500이며 최대 1000까지 요청가능합니다.
     * @param  array<string, mixed>|null  $filter  세금계산서 다건 조회 필터
     * @param  array<string, mixed>|null  $sort  세금계산서 다건 조회 시 정렬 조건: 미입력 시 상태 업데이트 일시 내림차순 정렬됩니다.
     */
    public function getB2bTaxInvoices(?bool $test = null, ?int $pageNumber = null, ?int $pageSize = null, ?array $filter = null, ?array $sort = null): Model\GetB2bTaxInvoicesResponse
    {
        return $this->callOperationWithQueryRequestBody('getB2bTaxInvoices', 'GET', '/b2b/tax-invoices', [], ['test' => $test, 'pageNumber' => $pageNumber, 'pageSize' => $pageSize, 'filter' => $filter, 'sort' => $sort], Model\GetB2bTaxInvoicesResponse::class);
    }

    /**
     * 세금 계산서 다건조회 기능입니다.
     * 조회 기간 내 등록된 세금 계산서를 다건 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  int|null  $pageNumber  0부터 시작하는 페이지 번호. 기본 값은 0.
     * @param  int|null  $pageSize  페이지 크기: 각 페이지 당 포함할 객체 수. 기본 값은 500이며 최대 1000까지 요청가능합니다.
     * @param  array<string, mixed>|null  $filter  세금계산서 다건 조회 필터
     * @param  array<string, mixed>|null  $sort  세금계산서 다건 조회 시 정렬 조건: 미입력 시 상태 업데이트 일시 내림차순 정렬됩니다.
     */
    public function getB2bTaxInvoicesAsync(?bool $test = null, ?int $pageNumber = null, ?int $pageSize = null, ?array $filter = null, ?array $sort = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getB2bTaxInvoices', 'GET', '/b2b/tax-invoices', [], ['test' => $test, 'pageNumber' => $pageNumber, 'pageSize' => $pageSize, 'filter' => $filter, 'sort' => $sort], Model\GetB2bTaxInvoicesResponse::class);
    }

    /**
     * 세금계산서 발행 승인 기능입니다.
     * 역발행의 경우 역발행요청(REQUESTED) 상태, 정발행의 경우 임시저장(DRAFTED) 상태의 세금계산서에 대해 발행을 승인합니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  string|null  $memo  메모
     * @param  string|null  $emailSubject  이메일 제목
     */
    public function issueB2bTaxInvoice(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null, ?string $emailSubject = null): Model\IssueB2bTaxInvoiceResponse
    {
        return $this->callOperationWithQueryAndBody('issueB2bTaxInvoice', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/issue', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo, 'emailSubject' => $emailSubject], Model\IssueB2bTaxInvoiceResponse::class);
    }

    /**
     * 세금계산서 발행 승인 기능입니다.
     * 역발행의 경우 역발행요청(REQUESTED) 상태, 정발행의 경우 임시저장(DRAFTED) 상태의 세금계산서에 대해 발행을 승인합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  string|null  $memo  메모
     * @param  string|null  $emailSubject  이메일 제목
     */
    public function issueB2bTaxInvoiceAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null, ?string $emailSubject = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('issueB2bTaxInvoice', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/issue', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo, 'emailSubject' => $emailSubject], Model\IssueB2bTaxInvoiceResponse::class);
    }

    /**
     * 세금계산서 즉시 정발행 기능입니다.
     * 세금계산서를 즉시 정발행합니다. 임시저장 API와 정발행 API 기능을 한 번의 프로세스로 처리합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  array<string, mixed>|null  $taxInvoice  세금계산서 생성 요청 정보
     * @param  string|null  $memo  메모
     * @param  array<string, mixed>|null  $modification  수정 세금계산서 생성 입력 정보
     * @param  bool|null  $createRecipientCounterparty  공급받는자 거래처 생성 여부: true인 경우 공급받는자 정보로 거래처를 자동 생성합니다.
     */
    public function issueB2bTaxInvoiceImmediately(?bool $test = null, ?array $taxInvoice = null, ?string $memo = null, ?array $modification = null, ?bool $createRecipientCounterparty = null): Model\IssueB2bTaxInvoiceImmediatelyResponse
    {
        return $this->callOperationWithQueryAndBody('issueB2bTaxInvoiceImmediately', 'POST', '/b2b/tax-invoices/issue-immediately', ['test' => $test], ['taxInvoice' => $taxInvoice, 'memo' => $memo, 'modification' => $modification, 'createRecipientCounterparty' => $createRecipientCounterparty], Model\IssueB2bTaxInvoiceImmediatelyResponse::class);
    }

    /**
     * 세금계산서 즉시 정발행 기능입니다.
     * 세금계산서를 즉시 정발행합니다. 임시저장 API와 정발행 API 기능을 한 번의 프로세스로 처리합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  array<string, mixed>|null  $taxInvoice  세금계산서 생성 요청 정보
     * @param  string|null  $memo  메모
     * @param  array<string, mixed>|null  $modification  수정 세금계산서 생성 입력 정보
     * @param  bool|null  $createRecipientCounterparty  공급받는자 거래처 생성 여부: true인 경우 공급받는자 정보로 거래처를 자동 생성합니다.
     */
    public function issueB2bTaxInvoiceImmediatelyAsync(?bool $test = null, ?array $taxInvoice = null, ?string $memo = null, ?array $modification = null, ?bool $createRecipientCounterparty = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('issueB2bTaxInvoiceImmediately', 'POST', '/b2b/tax-invoices/issue-immediately', ['test' => $test], ['taxInvoice' => $taxInvoice, 'memo' => $memo, 'modification' => $modification, 'createRecipientCounterparty' => $createRecipientCounterparty], Model\IssueB2bTaxInvoiceImmediatelyResponse::class);
    }

    /**
     * 세금계산서 역발행 요청 거부 기능입니다.
     * 공급자가 공급받는자로부터 요청받은 세금계산서 역발행 건을 거부합니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  string|null  $memo  메모
     */
    public function refuseB2bTaxInvoiceRequest(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null): Model\RefuseB2bTaxInvoiceRequestResponse
    {
        return $this->callOperationWithQueryAndBody('refuseB2bTaxInvoiceRequest', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/refuse-request', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo], Model\RefuseB2bTaxInvoiceRequestResponse::class);
    }

    /**
     * 세금계산서 역발행 요청 거부 기능입니다.
     * 공급자가 공급받는자로부터 요청받은 세금계산서 역발행 건을 거부합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  string|null  $memo  메모
     */
    public function refuseB2bTaxInvoiceRequestAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('refuseB2bTaxInvoiceRequest', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/refuse-request', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo], Model\RefuseB2bTaxInvoiceRequestResponse::class);
    }

    /**
     * 세금계산서 역발행 요청 기능입니다.
     * 임시저장(REGISTERED) 상태의 역발행 세금계산서를 공급자에게 발행 요청합니다. 요청이 완료되면 (역)발행대기 상태로 전환됩니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function requestB2bTaxInvoice(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Model\RequestB2bTaxInvoiceResponse
    {
        return $this->callOperation('requestB2bTaxInvoice', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/request', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Model\RequestB2bTaxInvoiceResponse::class, false);
    }

    /**
     * 세금계산서 역발행 요청 기능입니다.
     * 임시저장(REGISTERED) 상태의 역발행 세금계산서를 공급자에게 발행 요청합니다. 요청이 완료되면 (역)발행대기 상태로 전환됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function requestB2bTaxInvoiceAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('requestB2bTaxInvoice', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/request', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Model\RequestB2bTaxInvoiceResponse::class, false);
    }

    /**
     * 세금계산서 역발행 즉시 요청 기능입니다.
     * 공급자에게 세금계산서 역발행을 즉시 요청합니다. 임시저장 API와 역발행 요청 API 기능을 한 번의 프로세스로 처리합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  array<string, mixed>|null  $taxInvoice  세금계산서 생성 요청 정보
     * @param  string|null  $memo  메모
     * @param  array<string, mixed>|null  $modification  수정 세금계산서 생성 입력 정보
     */
    public function requestB2bTaxInvoiceReverseIssuance(?bool $test = null, ?array $taxInvoice = null, ?string $memo = null, ?array $modification = null): Model\RequestB2bTaxInvoiceReverseIssuanceResponse
    {
        return $this->callOperationWithQueryAndBody('requestB2bTaxInvoiceReverseIssuance', 'POST', '/b2b/tax-invoices/request-reverse-issuance', ['test' => $test], ['taxInvoice' => $taxInvoice, 'memo' => $memo, 'modification' => $modification], Model\RequestB2bTaxInvoiceReverseIssuanceResponse::class);
    }

    /**
     * 세금계산서 역발행 즉시 요청 기능입니다.
     * 공급자에게 세금계산서 역발행을 즉시 요청합니다. 임시저장 API와 역발행 요청 API 기능을 한 번의 프로세스로 처리합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  array<string, mixed>|null  $taxInvoice  세금계산서 생성 요청 정보
     * @param  string|null  $memo  메모
     * @param  array<string, mixed>|null  $modification  수정 세금계산서 생성 입력 정보
     */
    public function requestB2bTaxInvoiceReverseIssuanceAsync(?bool $test = null, ?array $taxInvoice = null, ?string $memo = null, ?array $modification = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('requestB2bTaxInvoiceReverseIssuance', 'POST', '/b2b/tax-invoices/request-reverse-issuance', ['test' => $test], ['taxInvoice' => $taxInvoice, 'memo' => $memo, 'modification' => $modification], Model\RequestB2bTaxInvoiceReverseIssuanceResponse::class);
    }

    /**
     * 세금계산서 국세청 즉시 전송 기능입니다.
     * 발행이 완료된 세금계산서를 국세청에 즉시 전송합니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function sendToNtsB2bTaxInvoice(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Model\SendToNtsB2bTaxInvoiceResponse
    {
        return $this->callOperation('sendToNtsB2bTaxInvoice', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/send-to-nts', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Model\SendToNtsB2bTaxInvoiceResponse::class, false);
    }

    /**
     * 세금계산서 국세청 즉시 전송 기능입니다.
     * 발행이 완료된 세금계산서를 국세청에 즉시 전송합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $brn  사업자등록번호
     * @param  string|null  $taxInvoiceKeyType  문서 번호 유형: query 파라미터로 전달된 문서번호 유형. 기본 값은 TAX_INVOICE_ID이며 SUPPLIER, RECIPIENT, TAX_INVOICE_ID을 지원합니다.
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     */
    public function sendToNtsB2bTaxInvoiceAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('sendToNtsB2bTaxInvoice', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/send-to-nts', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Model\SendToNtsB2bTaxInvoiceResponse::class, false);
    }

    /**
     * 세금계산서 임시저장 수정 기능입니다.
     * 임시 저장된 세금계산서를 수정합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  string|null  $brn  사업자등록번호: taxInvoiceKeyType이 TAX_INVOICE_ID가 아닌 경우 필수 값입니다.
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $taxInvoiceKeyType  세금계산서 식별자 유형: 기본 값은 RECIPIENT이며 SUPPLIER, RECIPIENT을 지원합니다.
     * @param  array<string, mixed>|null  $taxInvoice  세금계산서 생성 요청 정보
     * @param  string|null  $memo  메모
     */
    public function updateB2bTaxInvoiceDraft(?bool $test = null, ?string $brn = null, ?string $taxInvoiceKey = null, ?string $taxInvoiceKeyType = null, ?array $taxInvoice = null, ?string $memo = null): Model\UpdateB2bTaxInvoiceDraftResponse
    {
        return $this->callOperationWithQueryAndBody('updateB2bTaxInvoiceDraft', 'PUT', '/b2b/tax-invoices/draft', ['test' => $test], ['brn' => $brn, 'taxInvoiceKey' => $taxInvoiceKey, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'taxInvoice' => $taxInvoice, 'memo' => $memo], Model\UpdateB2bTaxInvoiceDraftResponse::class);
    }

    /**
     * 세금계산서 임시저장 수정 기능입니다.
     * 임시 저장된 세금계산서를 수정합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  string|null  $brn  사업자등록번호: taxInvoiceKeyType이 TAX_INVOICE_ID가 아닌 경우 필수 값입니다.
     * @param  string|null  $taxInvoiceKey  세금계산서 문서 번호
     * @param  string|null  $taxInvoiceKeyType  세금계산서 식별자 유형: 기본 값은 RECIPIENT이며 SUPPLIER, RECIPIENT을 지원합니다.
     * @param  array<string, mixed>|null  $taxInvoice  세금계산서 생성 요청 정보
     * @param  string|null  $memo  메모
     */
    public function updateB2bTaxInvoiceDraftAsync(?bool $test = null, ?string $brn = null, ?string $taxInvoiceKey = null, ?string $taxInvoiceKeyType = null, ?array $taxInvoice = null, ?string $memo = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updateB2bTaxInvoiceDraft', 'PUT', '/b2b/tax-invoices/draft', ['test' => $test], ['brn' => $brn, 'taxInvoiceKey' => $taxInvoiceKey, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'taxInvoice' => $taxInvoice, 'memo' => $memo], Model\UpdateB2bTaxInvoiceDraftResponse::class);
    }
}
