<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class TransferClient extends AbstractClient
{
    public function createPlatformManualTransfer(mixed $test = null, mixed $partnerId = null, mixed $memo = null, mixed $settlementAmount = null, mixed $settlementTaxFreeAmount = null, mixed $settlementDate = null, mixed $isForTest = null, mixed $userDefinedProperties = null, mixed $id = null, mixed $settlementCurrency = null): Response\CreateManualTransferResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformManualTransfer', 'POST', '/platform/transfers/manual', ['test' => $test], ['partnerId' => $partnerId, 'memo' => $memo, 'settlementAmount' => $settlementAmount, 'settlementTaxFreeAmount' => $settlementTaxFreeAmount, 'settlementDate' => $settlementDate, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id, 'settlementCurrency' => $settlementCurrency], Response\CreateManualTransferResponse::class);
    }

    public function createPlatformManualTransferAsync(mixed $test = null, mixed $partnerId = null, mixed $memo = null, mixed $settlementAmount = null, mixed $settlementTaxFreeAmount = null, mixed $settlementDate = null, mixed $isForTest = null, mixed $userDefinedProperties = null, mixed $id = null, mixed $settlementCurrency = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformManualTransfer', 'POST', '/platform/transfers/manual', ['test' => $test], ['partnerId' => $partnerId, 'memo' => $memo, 'settlementAmount' => $settlementAmount, 'settlementTaxFreeAmount' => $settlementTaxFreeAmount, 'settlementDate' => $settlementDate, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id, 'settlementCurrency' => $settlementCurrency], Response\CreateManualTransferResponse::class);
    }

    public function createPlatformOrderCancelTransfer(mixed $test = null, mixed $partnerId = null, mixed $paymentId = null, mixed $transferId = null, mixed $cancellationId = null, mixed $memo = null, mixed $orderDetail = null, mixed $taxFreeAmount = null, mixed $discounts = null, mixed $settlementStartDate = null, mixed $settlementDate = null, mixed $externalCancellationDetail = null, mixed $isForTest = null, mixed $userDefinedProperties = null, mixed $id = null): Response\CreateOrderCancelTransferResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformOrderCancelTransfer', 'POST', '/platform/transfers/order-cancel', ['test' => $test], ['partnerId' => $partnerId, 'paymentId' => $paymentId, 'transferId' => $transferId, 'cancellationId' => $cancellationId, 'memo' => $memo, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'discounts' => $discounts, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'externalCancellationDetail' => $externalCancellationDetail, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Response\CreateOrderCancelTransferResponse::class);
    }

    public function createPlatformOrderCancelTransferAsync(mixed $test = null, mixed $partnerId = null, mixed $paymentId = null, mixed $transferId = null, mixed $cancellationId = null, mixed $memo = null, mixed $orderDetail = null, mixed $taxFreeAmount = null, mixed $discounts = null, mixed $settlementStartDate = null, mixed $settlementDate = null, mixed $externalCancellationDetail = null, mixed $isForTest = null, mixed $userDefinedProperties = null, mixed $id = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformOrderCancelTransfer', 'POST', '/platform/transfers/order-cancel', ['test' => $test], ['partnerId' => $partnerId, 'paymentId' => $paymentId, 'transferId' => $transferId, 'cancellationId' => $cancellationId, 'memo' => $memo, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'discounts' => $discounts, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'externalCancellationDetail' => $externalCancellationDetail, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Response\CreateOrderCancelTransferResponse::class);
    }

    public function createPlatformOrderTransfer(mixed $test = null, mixed $partnerId = null, mixed $contractId = null, mixed $memo = null, mixed $paymentId = null, mixed $orderDetail = null, mixed $taxFreeAmount = null, mixed $settlementStartDate = null, mixed $settlementDate = null, mixed $discounts = null, mixed $additionalFees = null, mixed $externalPaymentDetail = null, mixed $isForTest = null, mixed $parameters = null, mixed $userDefinedProperties = null, mixed $id = null): Response\CreateOrderTransferResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformOrderTransfer', 'POST', '/platform/transfers/order', ['test' => $test], ['partnerId' => $partnerId, 'contractId' => $contractId, 'memo' => $memo, 'paymentId' => $paymentId, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'discounts' => $discounts, 'additionalFees' => $additionalFees, 'externalPaymentDetail' => $externalPaymentDetail, 'isForTest' => $isForTest, 'parameters' => $parameters, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Response\CreateOrderTransferResponse::class);
    }

    public function createPlatformOrderTransferAsync(mixed $test = null, mixed $partnerId = null, mixed $contractId = null, mixed $memo = null, mixed $paymentId = null, mixed $orderDetail = null, mixed $taxFreeAmount = null, mixed $settlementStartDate = null, mixed $settlementDate = null, mixed $discounts = null, mixed $additionalFees = null, mixed $externalPaymentDetail = null, mixed $isForTest = null, mixed $parameters = null, mixed $userDefinedProperties = null, mixed $id = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformOrderTransfer', 'POST', '/platform/transfers/order', ['test' => $test], ['partnerId' => $partnerId, 'contractId' => $contractId, 'memo' => $memo, 'paymentId' => $paymentId, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'discounts' => $discounts, 'additionalFees' => $additionalFees, 'externalPaymentDetail' => $externalPaymentDetail, 'isForTest' => $isForTest, 'parameters' => $parameters, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Response\CreateOrderTransferResponse::class);
    }

    public function deletePlatformTransfer(mixed $id = null, mixed $test = null): Response\DeletePlatformTransferResponse
    {
        return $this->callOperation('deletePlatformTransfer', 'DELETE', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Response\DeletePlatformTransferResponse::class, false);
    }

    public function deletePlatformTransferAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('deletePlatformTransfer', 'DELETE', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Response\DeletePlatformTransferResponse::class, false);
    }

    public function downloadPlatformTransferSheet(mixed $test = null, mixed $filter = null, mixed $fields = null): string
    {
        return $this->callStringOperationWithQueryRequestBody('downloadPlatformTransferSheet', 'GET', '/platform/transfer-summaries/sheet-file', ['test' => $test], ['filter' => $filter, 'fields' => $fields]);
    }

    public function downloadPlatformTransferSheetAsync(mixed $test = null, mixed $filter = null, mixed $fields = null): Future
    {
        return $this->callStringOperationWithQueryRequestBodyAsync('downloadPlatformTransferSheet', 'GET', '/platform/transfer-summaries/sheet-file', ['test' => $test], ['filter' => $filter, 'fields' => $fields]);
    }

    public function getPlatformTransfer(mixed $id = null, mixed $test = null): Response\PlatformTransfer
    {
        return $this->callOperation('getPlatformTransfer', 'GET', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Response\PlatformTransfer::class, false);
    }

    public function getPlatformTransferAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('getPlatformTransfer', 'GET', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Response\PlatformTransfer::class, false);
    }

    public function getPlatformTransferSummaries(mixed $test = null, mixed $page = null, mixed $filter = null): Response\GetPlatformTransferSummariesResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformTransferSummaries', 'GET', '/platform/transfer-summaries', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetPlatformTransferSummariesResponse::class);
    }

    public function getPlatformTransferSummariesAsync(mixed $test = null, mixed $page = null, mixed $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformTransferSummaries', 'GET', '/platform/transfer-summaries', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetPlatformTransferSummariesResponse::class);
    }
}
