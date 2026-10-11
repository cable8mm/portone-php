<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class TransferClient extends AbstractClient
{
    public function createPlatformManualTransfer(?bool $test = null, ?string $partnerId = null, ?string $memo = null, ?int $settlementAmount = null, ?int $settlementTaxFreeAmount = null, ?string $settlementDate = null, ?bool $isForTest = null, ?array $userDefinedProperties = null, ?string $id = null, ?string $settlementCurrency = null): Response\CreateManualTransferResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformManualTransfer', 'POST', '/platform/transfers/manual', ['test' => $test], ['partnerId' => $partnerId, 'memo' => $memo, 'settlementAmount' => $settlementAmount, 'settlementTaxFreeAmount' => $settlementTaxFreeAmount, 'settlementDate' => $settlementDate, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id, 'settlementCurrency' => $settlementCurrency], Response\CreateManualTransferResponse::class);
    }

    public function createPlatformManualTransferAsync(?bool $test = null, ?string $partnerId = null, ?string $memo = null, ?int $settlementAmount = null, ?int $settlementTaxFreeAmount = null, ?string $settlementDate = null, ?bool $isForTest = null, ?array $userDefinedProperties = null, ?string $id = null, ?string $settlementCurrency = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformManualTransfer', 'POST', '/platform/transfers/manual', ['test' => $test], ['partnerId' => $partnerId, 'memo' => $memo, 'settlementAmount' => $settlementAmount, 'settlementTaxFreeAmount' => $settlementTaxFreeAmount, 'settlementDate' => $settlementDate, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id, 'settlementCurrency' => $settlementCurrency], Response\CreateManualTransferResponse::class);
    }

    public function createPlatformOrderCancelTransfer(?bool $test = null, ?string $partnerId = null, ?string $paymentId = null, ?string $transferId = null, ?string $cancellationId = null, ?string $memo = null, ?array $orderDetail = null, ?int $taxFreeAmount = null, ?array $discounts = null, ?string $settlementStartDate = null, ?string $settlementDate = null, ?array $externalCancellationDetail = null, ?bool $isForTest = null, ?array $userDefinedProperties = null, ?string $id = null): Response\CreateOrderCancelTransferResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformOrderCancelTransfer', 'POST', '/platform/transfers/order-cancel', ['test' => $test], ['partnerId' => $partnerId, 'paymentId' => $paymentId, 'transferId' => $transferId, 'cancellationId' => $cancellationId, 'memo' => $memo, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'discounts' => $discounts, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'externalCancellationDetail' => $externalCancellationDetail, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Response\CreateOrderCancelTransferResponse::class);
    }

    public function createPlatformOrderCancelTransferAsync(?bool $test = null, ?string $partnerId = null, ?string $paymentId = null, ?string $transferId = null, ?string $cancellationId = null, ?string $memo = null, ?array $orderDetail = null, ?int $taxFreeAmount = null, ?array $discounts = null, ?string $settlementStartDate = null, ?string $settlementDate = null, ?array $externalCancellationDetail = null, ?bool $isForTest = null, ?array $userDefinedProperties = null, ?string $id = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformOrderCancelTransfer', 'POST', '/platform/transfers/order-cancel', ['test' => $test], ['partnerId' => $partnerId, 'paymentId' => $paymentId, 'transferId' => $transferId, 'cancellationId' => $cancellationId, 'memo' => $memo, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'discounts' => $discounts, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'externalCancellationDetail' => $externalCancellationDetail, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Response\CreateOrderCancelTransferResponse::class);
    }

    public function createPlatformOrderTransfer(?bool $test = null, ?string $partnerId = null, ?string $contractId = null, ?string $memo = null, ?string $paymentId = null, ?array $orderDetail = null, ?int $taxFreeAmount = null, ?string $settlementStartDate = null, ?string $settlementDate = null, ?array $discounts = null, ?array $additionalFees = null, ?array $externalPaymentDetail = null, ?bool $isForTest = null, ?array $parameters = null, ?array $userDefinedProperties = null, ?string $id = null): Response\CreateOrderTransferResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformOrderTransfer', 'POST', '/platform/transfers/order', ['test' => $test], ['partnerId' => $partnerId, 'contractId' => $contractId, 'memo' => $memo, 'paymentId' => $paymentId, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'discounts' => $discounts, 'additionalFees' => $additionalFees, 'externalPaymentDetail' => $externalPaymentDetail, 'isForTest' => $isForTest, 'parameters' => $parameters, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Response\CreateOrderTransferResponse::class);
    }

    public function createPlatformOrderTransferAsync(?bool $test = null, ?string $partnerId = null, ?string $contractId = null, ?string $memo = null, ?string $paymentId = null, ?array $orderDetail = null, ?int $taxFreeAmount = null, ?string $settlementStartDate = null, ?string $settlementDate = null, ?array $discounts = null, ?array $additionalFees = null, ?array $externalPaymentDetail = null, ?bool $isForTest = null, ?array $parameters = null, ?array $userDefinedProperties = null, ?string $id = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformOrderTransfer', 'POST', '/platform/transfers/order', ['test' => $test], ['partnerId' => $partnerId, 'contractId' => $contractId, 'memo' => $memo, 'paymentId' => $paymentId, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'discounts' => $discounts, 'additionalFees' => $additionalFees, 'externalPaymentDetail' => $externalPaymentDetail, 'isForTest' => $isForTest, 'parameters' => $parameters, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Response\CreateOrderTransferResponse::class);
    }

    public function deletePlatformTransfer(?string $id = null, ?bool $test = null): Response\DeletePlatformTransferResponse
    {
        return $this->callOperation('deletePlatformTransfer', 'DELETE', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Response\DeletePlatformTransferResponse::class, false);
    }

    public function deletePlatformTransferAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('deletePlatformTransfer', 'DELETE', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Response\DeletePlatformTransferResponse::class, false);
    }

    public function downloadPlatformTransferSheet(?bool $test = null, ?array $filter = null, ?array $fields = null): string
    {
        return $this->callStringOperationWithQueryRequestBody('downloadPlatformTransferSheet', 'GET', '/platform/transfer-summaries/sheet-file', ['test' => $test], ['filter' => $filter, 'fields' => $fields]);
    }

    public function downloadPlatformTransferSheetAsync(?bool $test = null, ?array $filter = null, ?array $fields = null): Future
    {
        return $this->callStringOperationWithQueryRequestBodyAsync('downloadPlatformTransferSheet', 'GET', '/platform/transfer-summaries/sheet-file', ['test' => $test], ['filter' => $filter, 'fields' => $fields]);
    }

    public function getPlatformTransfer(?string $id = null, ?bool $test = null): Response\PlatformTransfer
    {
        return $this->callOperation('getPlatformTransfer', 'GET', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Response\PlatformTransfer::class, false);
    }

    public function getPlatformTransferAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformTransfer', 'GET', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Response\PlatformTransfer::class, false);
    }

    public function getPlatformTransferSummaries(?bool $test = null, ?array $page = null, ?array $filter = null): Response\GetPlatformTransferSummariesResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformTransferSummaries', 'GET', '/platform/transfer-summaries', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetPlatformTransferSummariesResponse::class);
    }

    public function getPlatformTransferSummariesAsync(?bool $test = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformTransferSummaries', 'GET', '/platform/transfer-summaries', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetPlatformTransferSummariesResponse::class);
    }
}
