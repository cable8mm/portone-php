<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 플랫폼 이체 API 작업을 제공합니다.
 */
final class TransferClient extends AbstractClient
{
    /**
     * 수기 정산건 생성 기능입니다.
     * 성공 응답으로 생성된 수기 정산건 객체가 반환됩니다.
     */
    public function createPlatformManualTransfer(?bool $test = null, ?string $partnerId = null, ?string $memo = null, ?int $settlementAmount = null, ?int $settlementTaxFreeAmount = null, ?string $settlementDate = null, ?bool $isForTest = null, ?array $userDefinedProperties = null, ?string $id = null, ?string $settlementCurrency = null): Model\CreateManualTransferResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformManualTransfer', 'POST', '/platform/transfers/manual', ['test' => $test], ['partnerId' => $partnerId, 'memo' => $memo, 'settlementAmount' => $settlementAmount, 'settlementTaxFreeAmount' => $settlementTaxFreeAmount, 'settlementDate' => $settlementDate, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id, 'settlementCurrency' => $settlementCurrency], Model\CreateManualTransferResponse::class);
    }

    /**
     * 수기 정산건 생성 기능입니다.
     * 성공 응답으로 생성된 수기 정산건 객체가 반환됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function createPlatformManualTransferAsync(?bool $test = null, ?string $partnerId = null, ?string $memo = null, ?int $settlementAmount = null, ?int $settlementTaxFreeAmount = null, ?string $settlementDate = null, ?bool $isForTest = null, ?array $userDefinedProperties = null, ?string $id = null, ?string $settlementCurrency = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformManualTransfer', 'POST', '/platform/transfers/manual', ['test' => $test], ['partnerId' => $partnerId, 'memo' => $memo, 'settlementAmount' => $settlementAmount, 'settlementTaxFreeAmount' => $settlementTaxFreeAmount, 'settlementDate' => $settlementDate, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id, 'settlementCurrency' => $settlementCurrency], Model\CreateManualTransferResponse::class);
    }

    /**
     * 주문 취소 정산건 생성 기능입니다.
     * 성공 응답으로 생성된 주문 취소 정산건 객체가 반환됩니다.
     */
    public function createPlatformOrderCancelTransfer(?bool $test = null, ?string $partnerId = null, ?string $paymentId = null, ?string $transferId = null, ?string $cancellationId = null, ?string $memo = null, ?array $orderDetail = null, ?int $taxFreeAmount = null, ?array $discounts = null, ?string $settlementStartDate = null, ?string $settlementDate = null, ?array $externalCancellationDetail = null, ?bool $isForTest = null, ?array $userDefinedProperties = null, ?string $id = null): Model\CreateOrderCancelTransferResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformOrderCancelTransfer', 'POST', '/platform/transfers/order-cancel', ['test' => $test], ['partnerId' => $partnerId, 'paymentId' => $paymentId, 'transferId' => $transferId, 'cancellationId' => $cancellationId, 'memo' => $memo, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'discounts' => $discounts, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'externalCancellationDetail' => $externalCancellationDetail, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Model\CreateOrderCancelTransferResponse::class);
    }

    /**
     * 주문 취소 정산건 생성 기능입니다.
     * 성공 응답으로 생성된 주문 취소 정산건 객체가 반환됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function createPlatformOrderCancelTransferAsync(?bool $test = null, ?string $partnerId = null, ?string $paymentId = null, ?string $transferId = null, ?string $cancellationId = null, ?string $memo = null, ?array $orderDetail = null, ?int $taxFreeAmount = null, ?array $discounts = null, ?string $settlementStartDate = null, ?string $settlementDate = null, ?array $externalCancellationDetail = null, ?bool $isForTest = null, ?array $userDefinedProperties = null, ?string $id = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformOrderCancelTransfer', 'POST', '/platform/transfers/order-cancel', ['test' => $test], ['partnerId' => $partnerId, 'paymentId' => $paymentId, 'transferId' => $transferId, 'cancellationId' => $cancellationId, 'memo' => $memo, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'discounts' => $discounts, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'externalCancellationDetail' => $externalCancellationDetail, 'isForTest' => $isForTest, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Model\CreateOrderCancelTransferResponse::class);
    }

    /**
     * 주문 정산건 생성 기능입니다.
     * 성공 응답으로 생성된 주문 정산건 객체가 반환됩니다.
     */
    public function createPlatformOrderTransfer(?bool $test = null, ?string $partnerId = null, ?string $contractId = null, ?string $memo = null, ?string $paymentId = null, ?array $orderDetail = null, ?int $taxFreeAmount = null, ?string $settlementStartDate = null, ?string $settlementDate = null, ?array $discounts = null, ?array $additionalFees = null, ?array $externalPaymentDetail = null, ?bool $isForTest = null, ?array $parameters = null, ?array $userDefinedProperties = null, ?string $id = null): Model\CreateOrderTransferResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformOrderTransfer', 'POST', '/platform/transfers/order', ['test' => $test], ['partnerId' => $partnerId, 'contractId' => $contractId, 'memo' => $memo, 'paymentId' => $paymentId, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'discounts' => $discounts, 'additionalFees' => $additionalFees, 'externalPaymentDetail' => $externalPaymentDetail, 'isForTest' => $isForTest, 'parameters' => $parameters, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Model\CreateOrderTransferResponse::class);
    }

    /**
     * 주문 정산건 생성 기능입니다.
     * 성공 응답으로 생성된 주문 정산건 객체가 반환됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function createPlatformOrderTransferAsync(?bool $test = null, ?string $partnerId = null, ?string $contractId = null, ?string $memo = null, ?string $paymentId = null, ?array $orderDetail = null, ?int $taxFreeAmount = null, ?string $settlementStartDate = null, ?string $settlementDate = null, ?array $discounts = null, ?array $additionalFees = null, ?array $externalPaymentDetail = null, ?bool $isForTest = null, ?array $parameters = null, ?array $userDefinedProperties = null, ?string $id = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformOrderTransfer', 'POST', '/platform/transfers/order', ['test' => $test], ['partnerId' => $partnerId, 'contractId' => $contractId, 'memo' => $memo, 'paymentId' => $paymentId, 'orderDetail' => $orderDetail, 'taxFreeAmount' => $taxFreeAmount, 'settlementStartDate' => $settlementStartDate, 'settlementDate' => $settlementDate, 'discounts' => $discounts, 'additionalFees' => $additionalFees, 'externalPaymentDetail' => $externalPaymentDetail, 'isForTest' => $isForTest, 'parameters' => $parameters, 'userDefinedProperties' => $userDefinedProperties, 'id' => $id], Model\CreateOrderTransferResponse::class);
    }

    /**
     * 정산건 삭제 기능입니다.
     * scheduled, in_process 상태의 정산건만 삭제가능합니다.
     */
    public function deletePlatformTransfer(?string $id = null, ?bool $test = null): Model\DeletePlatformTransferResponse
    {
        return $this->callOperation('deletePlatformTransfer', 'DELETE', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Model\DeletePlatformTransferResponse::class, false);
    }

    /**
     * 정산건 삭제 기능입니다.
     * scheduled, in_process 상태의 정산건만 삭제가능합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function deletePlatformTransferAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('deletePlatformTransfer', 'DELETE', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Model\DeletePlatformTransferResponse::class, false);
    }

    /**
     * 정산 상세 내역 다운로드 기능입니다.
     * 정산 상세 내역을 csv 파일로 다운로드 합니다.
     */
    public function downloadPlatformTransferSheet(?bool $test = null, ?array $filter = null, ?array $fields = null): string
    {
        return $this->callStringOperationWithQueryRequestBody('downloadPlatformTransferSheet', 'GET', '/platform/transfer-summaries/sheet-file', ['test' => $test], ['filter' => $filter, 'fields' => $fields]);
    }

    /**
     * 정산 상세 내역 다운로드 기능입니다.
     * 정산 상세 내역을 csv 파일로 다운로드 합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function downloadPlatformTransferSheetAsync(?bool $test = null, ?array $filter = null, ?array $fields = null): Future
    {
        return $this->callStringOperationWithQueryRequestBodyAsync('downloadPlatformTransferSheet', 'GET', '/platform/transfer-summaries/sheet-file', ['test' => $test], ['filter' => $filter, 'fields' => $fields]);
    }

    /**
     * 정산건 조회 기능입니다.
     * 정산건을 조회합니다.
     */
    public function getPlatformTransfer(?string $id = null, ?bool $test = null): Model\PlatformTransfer
    {
        return $this->callOperation('getPlatformTransfer', 'GET', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Model\PlatformTransfer::class, false);
    }

    /**
     * 정산건 조회 기능입니다.
     * 정산건을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformTransferAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformTransfer', 'GET', '/platform/transfers/{id}', ['id' => $id, 'test' => $test], Model\PlatformTransfer::class, false);
    }

    /**
     * 정산건 다건 조회 기능입니다.
     * 성공 응답으로 조회된 정산건 요약 리스트와 페이지 정보가 반환됩니다.
     */
    public function getPlatformTransferSummaries(?bool $test = null, ?array $page = null, ?array $filter = null): Model\GetPlatformTransferSummariesResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformTransferSummaries', 'GET', '/platform/transfer-summaries', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformTransferSummariesResponse::class);
    }

    /**
     * 정산건 다건 조회 기능입니다.
     * 성공 응답으로 조회된 정산건 요약 리스트와 페이지 정보가 반환됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformTransferSummariesAsync(?bool $test = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformTransferSummaries', 'GET', '/platform/transfer-summaries', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformTransferSummariesResponse::class);
    }
}
