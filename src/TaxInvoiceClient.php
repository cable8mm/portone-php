<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class TaxInvoiceClient extends AbstractClient
{
    public function attachB2bTaxInvoiceFile(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $fileId = null): void
    {
        $this->callUnitOperationWithQueryAndBody('attachB2bTaxInvoiceFile', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/attach-file', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['fileId' => $fileId]);
    }

    public function attachB2bTaxInvoiceFileAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $fileId = null): Future
    {
        return $this->callUnitOperationWithQueryAndBodyAsync('attachB2bTaxInvoiceFile', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/attach-file', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['fileId' => $fileId]);
    }

    public function cancelB2bTaxInvoiceIssuance(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null): Response\CancelB2bTaxInvoiceIssuanceResponse
    {
        return $this->callOperationWithQueryAndBody('cancelB2bTaxInvoiceIssuance', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/cancel-issuance', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo], Response\CancelB2bTaxInvoiceIssuanceResponse::class);
    }

    public function cancelB2bTaxInvoiceIssuanceAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('cancelB2bTaxInvoiceIssuance', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/cancel-issuance', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo], Response\CancelB2bTaxInvoiceIssuanceResponse::class);
    }

    public function cancelB2bTaxInvoiceRequest(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null): Response\CancelB2bTaxInvoiceRequestResponse
    {
        return $this->callOperationWithQueryAndBody('cancelB2bTaxInvoiceRequest', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/cancel-request', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo], Response\CancelB2bTaxInvoiceRequestResponse::class);
    }

    public function cancelB2bTaxInvoiceRequestAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('cancelB2bTaxInvoiceRequest', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/cancel-request', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo], Response\CancelB2bTaxInvoiceRequestResponse::class);
    }

    public function createB2bFileUploadUrl(?bool $test = null, ?string $fileName = null): Response\CreateB2bFileUploadUrlPayload
    {
        return $this->callOperationWithQueryAndBody('createB2bFileUploadUrl', 'POST', '/b2b/file-upload-url', ['test' => $test], ['fileName' => $fileName], Response\CreateB2bFileUploadUrlPayload::class);
    }

    public function createB2bFileUploadUrlAsync(?bool $test = null, ?string $fileName = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createB2bFileUploadUrl', 'POST', '/b2b/file-upload-url', ['test' => $test], ['fileName' => $fileName], Response\CreateB2bFileUploadUrlPayload::class);
    }

    public function deleteB2bTaxInvoice(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Response\DeleteB2bTaxInvoiceResponse
    {
        return $this->callOperation('deleteB2bTaxInvoice', 'DELETE', '/b2b/tax-invoices/{taxInvoiceKey}', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Response\DeleteB2bTaxInvoiceResponse::class, false);
    }

    public function deleteB2bTaxInvoiceAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('deleteB2bTaxInvoice', 'DELETE', '/b2b/tax-invoices/{taxInvoiceKey}', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Response\DeleteB2bTaxInvoiceResponse::class, false);
    }

    public function deleteB2bTaxInvoiceAttachment(?string $taxInvoiceKey = null, ?string $attachmentId = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): void
    {
        $this->callUnitOperationWithQuery('deleteB2bTaxInvoiceAttachment', 'DELETE', '/b2b/tax-invoices/{taxInvoiceKey}/attachments/{attachmentId}', ['taxInvoiceKey' => $taxInvoiceKey, 'attachmentId' => $attachmentId, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test]);
    }

    public function deleteB2bTaxInvoiceAttachmentAsync(?string $taxInvoiceKey = null, ?string $attachmentId = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callUnitOperationWithQueryAsync('deleteB2bTaxInvoiceAttachment', 'DELETE', '/b2b/tax-invoices/{taxInvoiceKey}/attachments/{attachmentId}', ['taxInvoiceKey' => $taxInvoiceKey, 'attachmentId' => $attachmentId, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test]);
    }

    public function downloadB2bTaxInvoicesSheet(?array $filter = null, ?array $fields = null, ?bool $test = null, ?array $sort = null): string
    {
        return $this->callStringOperationWithQueryRequestBody('downloadB2bTaxInvoicesSheet', 'GET', '/b2b/tax-invoices-sheet', [], ['filter' => $filter, 'fields' => $fields, 'test' => $test, 'sort' => $sort]);
    }

    public function downloadB2bTaxInvoicesSheetAsync(?array $filter = null, ?array $fields = null, ?bool $test = null, ?array $sort = null): Future
    {
        return $this->callStringOperationWithQueryRequestBodyAsync('downloadB2bTaxInvoicesSheet', 'GET', '/b2b/tax-invoices-sheet', [], ['filter' => $filter, 'fields' => $fields, 'test' => $test, 'sort' => $sort]);
    }

    public function draftB2bTaxInvoice(?bool $test = null, ?array $taxInvoice = null, ?array $modification = null, ?string $memo = null, ?bool $createRecipientCounterparty = null): Response\DraftB2bTaxInvoiceResponse
    {
        return $this->callOperationWithQueryAndBody('draftB2bTaxInvoice', 'POST', '/b2b/tax-invoices/draft', ['test' => $test], ['taxInvoice' => $taxInvoice, 'modification' => $modification, 'memo' => $memo, 'createRecipientCounterparty' => $createRecipientCounterparty], Response\DraftB2bTaxInvoiceResponse::class);
    }

    public function draftB2bTaxInvoiceAsync(?bool $test = null, ?array $taxInvoice = null, ?array $modification = null, ?string $memo = null, ?bool $createRecipientCounterparty = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('draftB2bTaxInvoice', 'POST', '/b2b/tax-invoices/draft', ['test' => $test], ['taxInvoice' => $taxInvoice, 'modification' => $modification, 'memo' => $memo, 'createRecipientCounterparty' => $createRecipientCounterparty], Response\DraftB2bTaxInvoiceResponse::class);
    }

    public function getB2bBulkTaxInvoice(?string $bulkTaxInvoiceId = null, ?bool $test = null): Response\B2bBulkTaxInvoice
    {
        return $this->callOperation('getB2bBulkTaxInvoice', 'GET', '/b2b/bulk-tax-invoices/{bulkTaxInvoiceId}', ['bulkTaxInvoiceId' => $bulkTaxInvoiceId, 'test' => $test], Response\B2bBulkTaxInvoice::class, false);
    }

    public function getB2bBulkTaxInvoiceAsync(?string $bulkTaxInvoiceId = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getB2bBulkTaxInvoice', 'GET', '/b2b/bulk-tax-invoices/{bulkTaxInvoiceId}', ['bulkTaxInvoiceId' => $bulkTaxInvoiceId, 'test' => $test], Response\B2bBulkTaxInvoice::class, false);
    }

    public function getB2bTaxInvoice(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Response\B2bTaxInvoice
    {
        return $this->callOperation('getB2bTaxInvoice', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Response\B2bTaxInvoice::class, false);
    }

    public function getB2bTaxInvoiceAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getB2bTaxInvoice', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Response\B2bTaxInvoice::class, false);
    }

    public function getB2bTaxInvoiceAttachments(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Response\GetB2bTaxInvoiceAttachmentsResponse
    {
        return $this->callOperation('getB2bTaxInvoiceAttachments', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/attachments', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Response\GetB2bTaxInvoiceAttachmentsResponse::class, false);
    }

    public function getB2bTaxInvoiceAttachmentsAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getB2bTaxInvoiceAttachments', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/attachments', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Response\GetB2bTaxInvoiceAttachmentsResponse::class, false);
    }

    public function getB2bTaxInvoicePdfDownloadUrl(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Response\GetB2bTaxInvoicePdfDownloadUrlResponse
    {
        return $this->callOperation('getB2bTaxInvoicePdfDownloadUrl', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/pdf-download-url', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Response\GetB2bTaxInvoicePdfDownloadUrlResponse::class, false);
    }

    public function getB2bTaxInvoicePdfDownloadUrlAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getB2bTaxInvoicePdfDownloadUrl', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/pdf-download-url', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Response\GetB2bTaxInvoicePdfDownloadUrlResponse::class, false);
    }

    public function getB2bTaxInvoicePopupUrl(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $includeMenu = null, ?bool $test = null): Response\GetB2bTaxInvoicePopupUrlResponse
    {
        return $this->callOperation('getB2bTaxInvoicePopupUrl', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/popup-url', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'includeMenu' => $includeMenu, 'test' => $test], Response\GetB2bTaxInvoicePopupUrlResponse::class, false);
    }

    public function getB2bTaxInvoicePopupUrlAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $includeMenu = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getB2bTaxInvoicePopupUrl', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/popup-url', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'includeMenu' => $includeMenu, 'test' => $test], Response\GetB2bTaxInvoicePopupUrlResponse::class, false);
    }

    public function getB2bTaxInvoicePrintUrl(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Response\GetB2bTaxInvoicePrintUrlResponse
    {
        return $this->callOperation('getB2bTaxInvoicePrintUrl', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/print-url', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Response\GetB2bTaxInvoicePrintUrlResponse::class, false);
    }

    public function getB2bTaxInvoicePrintUrlAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getB2bTaxInvoicePrintUrl', 'GET', '/b2b/tax-invoices/{taxInvoiceKey}/print-url', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Response\GetB2bTaxInvoicePrintUrlResponse::class, false);
    }

    public function getB2bTaxInvoices(?bool $test = null, ?int $pageNumber = null, ?int $pageSize = null, ?array $filter = null, ?array $sort = null): Response\GetB2bTaxInvoicesResponse
    {
        return $this->callOperationWithQueryRequestBody('getB2bTaxInvoices', 'GET', '/b2b/tax-invoices', [], ['test' => $test, 'pageNumber' => $pageNumber, 'pageSize' => $pageSize, 'filter' => $filter, 'sort' => $sort], Response\GetB2bTaxInvoicesResponse::class);
    }

    public function getB2bTaxInvoicesAsync(?bool $test = null, ?int $pageNumber = null, ?int $pageSize = null, ?array $filter = null, ?array $sort = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getB2bTaxInvoices', 'GET', '/b2b/tax-invoices', [], ['test' => $test, 'pageNumber' => $pageNumber, 'pageSize' => $pageSize, 'filter' => $filter, 'sort' => $sort], Response\GetB2bTaxInvoicesResponse::class);
    }

    public function issueB2bTaxInvoice(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null, ?string $emailSubject = null): Response\IssueB2bTaxInvoiceResponse
    {
        return $this->callOperationWithQueryAndBody('issueB2bTaxInvoice', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/issue', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo, 'emailSubject' => $emailSubject], Response\IssueB2bTaxInvoiceResponse::class);
    }

    public function issueB2bTaxInvoiceAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null, ?string $emailSubject = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('issueB2bTaxInvoice', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/issue', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo, 'emailSubject' => $emailSubject], Response\IssueB2bTaxInvoiceResponse::class);
    }

    public function issueB2bTaxInvoiceImmediately(?bool $test = null, ?array $taxInvoice = null, ?string $memo = null, ?array $modification = null, ?bool $createRecipientCounterparty = null): Response\IssueB2bTaxInvoiceImmediatelyResponse
    {
        return $this->callOperationWithQueryAndBody('issueB2bTaxInvoiceImmediately', 'POST', '/b2b/tax-invoices/issue-immediately', ['test' => $test], ['taxInvoice' => $taxInvoice, 'memo' => $memo, 'modification' => $modification, 'createRecipientCounterparty' => $createRecipientCounterparty], Response\IssueB2bTaxInvoiceImmediatelyResponse::class);
    }

    public function issueB2bTaxInvoiceImmediatelyAsync(?bool $test = null, ?array $taxInvoice = null, ?string $memo = null, ?array $modification = null, ?bool $createRecipientCounterparty = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('issueB2bTaxInvoiceImmediately', 'POST', '/b2b/tax-invoices/issue-immediately', ['test' => $test], ['taxInvoice' => $taxInvoice, 'memo' => $memo, 'modification' => $modification, 'createRecipientCounterparty' => $createRecipientCounterparty], Response\IssueB2bTaxInvoiceImmediatelyResponse::class);
    }

    public function refuseB2bTaxInvoiceRequest(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null): Response\RefuseB2bTaxInvoiceRequestResponse
    {
        return $this->callOperationWithQueryAndBody('refuseB2bTaxInvoiceRequest', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/refuse-request', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo], Response\RefuseB2bTaxInvoiceRequestResponse::class);
    }

    public function refuseB2bTaxInvoiceRequestAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null, ?string $memo = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('refuseB2bTaxInvoiceRequest', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/refuse-request', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], ['memo' => $memo], Response\RefuseB2bTaxInvoiceRequestResponse::class);
    }

    public function requestB2bTaxInvoice(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Response\RequestB2bTaxInvoiceResponse
    {
        return $this->callOperation('requestB2bTaxInvoice', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/request', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Response\RequestB2bTaxInvoiceResponse::class, false);
    }

    public function requestB2bTaxInvoiceAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('requestB2bTaxInvoice', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/request', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Response\RequestB2bTaxInvoiceResponse::class, false);
    }

    public function requestB2bTaxInvoiceReverseIssuance(?bool $test = null, ?array $taxInvoice = null, ?string $memo = null, ?array $modification = null): Response\RequestB2bTaxInvoiceReverseIssuanceResponse
    {
        return $this->callOperationWithQueryAndBody('requestB2bTaxInvoiceReverseIssuance', 'POST', '/b2b/tax-invoices/request-reverse-issuance', ['test' => $test], ['taxInvoice' => $taxInvoice, 'memo' => $memo, 'modification' => $modification], Response\RequestB2bTaxInvoiceReverseIssuanceResponse::class);
    }

    public function requestB2bTaxInvoiceReverseIssuanceAsync(?bool $test = null, ?array $taxInvoice = null, ?string $memo = null, ?array $modification = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('requestB2bTaxInvoiceReverseIssuance', 'POST', '/b2b/tax-invoices/request-reverse-issuance', ['test' => $test], ['taxInvoice' => $taxInvoice, 'memo' => $memo, 'modification' => $modification], Response\RequestB2bTaxInvoiceReverseIssuanceResponse::class);
    }

    public function sendToNtsB2bTaxInvoice(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Response\SendToNtsB2bTaxInvoiceResponse
    {
        return $this->callOperation('sendToNtsB2bTaxInvoice', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/send-to-nts', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Response\SendToNtsB2bTaxInvoiceResponse::class, false);
    }

    public function sendToNtsB2bTaxInvoiceAsync(?string $taxInvoiceKey = null, ?string $brn = null, ?string $taxInvoiceKeyType = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('sendToNtsB2bTaxInvoice', 'POST', '/b2b/tax-invoices/{taxInvoiceKey}/send-to-nts', ['taxInvoiceKey' => $taxInvoiceKey, 'brn' => $brn, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'test' => $test], Response\SendToNtsB2bTaxInvoiceResponse::class, false);
    }

    public function updateB2bTaxInvoiceDraft(?bool $test = null, ?string $brn = null, ?string $taxInvoiceKey = null, ?string $taxInvoiceKeyType = null, ?array $taxInvoice = null, ?string $memo = null): Response\UpdateB2bTaxInvoiceDraftResponse
    {
        return $this->callOperationWithQueryAndBody('updateB2bTaxInvoiceDraft', 'PUT', '/b2b/tax-invoices/draft', ['test' => $test], ['brn' => $brn, 'taxInvoiceKey' => $taxInvoiceKey, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'taxInvoice' => $taxInvoice, 'memo' => $memo], Response\UpdateB2bTaxInvoiceDraftResponse::class);
    }

    public function updateB2bTaxInvoiceDraftAsync(?bool $test = null, ?string $brn = null, ?string $taxInvoiceKey = null, ?string $taxInvoiceKeyType = null, ?array $taxInvoice = null, ?string $memo = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updateB2bTaxInvoiceDraft', 'PUT', '/b2b/tax-invoices/draft', ['test' => $test], ['brn' => $brn, 'taxInvoiceKey' => $taxInvoiceKey, 'taxInvoiceKeyType' => $taxInvoiceKeyType, 'taxInvoice' => $taxInvoice, 'memo' => $memo], Response\UpdateB2bTaxInvoiceDraftResponse::class);
    }
}
