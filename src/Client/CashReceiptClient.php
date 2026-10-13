<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 현금영수증 API 작업을 제공합니다.
 */
final class CashReceiptClient extends AbstractClient
{
    /**
     * 현금 영수증 취소 기능입니다.
     * 현금 영수증 취소를 요청합니다.
     */
    public function cancelCashReceiptByPaymentId(?string $paymentId = null, ?string $storeId = null): Model\CancelCashReceiptResponse
    {
        return $this->callOperation('cancelCashReceiptByPaymentId', 'POST', '/payments/{paymentId}/cash-receipt/cancel', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CancelCashReceiptResponse::class, false);
    }

    /**
     * 현금 영수증 취소 기능입니다.
     * 현금 영수증 취소를 요청합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function cancelCashReceiptByPaymentIdAsync(?string $paymentId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('cancelCashReceiptByPaymentId', 'POST', '/payments/{paymentId}/cash-receipt/cancel', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CancelCashReceiptResponse::class, false);
    }

    /**
     * 현금 영수증 단건 조회 기능입니다.
     * 주어진 결제 아이디에 대응되는 현금 영수증 내역을 조회합니다.
     */
    public function getCashReceiptByPaymentId(?string $paymentId = null, ?string $storeId = null): Model\CashReceipt
    {
        return $this->callOperation('getCashReceiptByPaymentId', 'GET', '/payments/{paymentId}/cash-receipt', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CashReceipt::class, false);
    }

    /**
     * 현금 영수증 단건 조회 기능입니다.
     * 주어진 결제 아이디에 대응되는 현금 영수증 내역을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getCashReceiptByPaymentIdAsync(?string $paymentId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getCashReceiptByPaymentId', 'GET', '/payments/{paymentId}/cash-receipt', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CashReceipt::class, false);
    }

    /**
     * 현금영수증 다건 조회 기능입니다.
     * 주어진 조건에 맞는 현금영수증들을 페이지 기반으로 조회합니다.
     */
    public function getCashReceipts(?array $page = null, ?array $sort = null, ?array $filter = null): Model\GetCashReceiptsResponse
    {
        return $this->callOperation('getCashReceipts', 'GET', '/cash-receipts', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetCashReceiptsResponse::class, true);
    }

    /**
     * 현금영수증 다건 조회 기능입니다.
     * 주어진 조건에 맞는 현금영수증들을 페이지 기반으로 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getCashReceiptsAsync(?array $page = null, ?array $sort = null, ?array $filter = null): Future
    {
        return $this->callOperationAsync('getCashReceipts', 'GET', '/cash-receipts', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetCashReceiptsResponse::class, true);
    }

    /**
     * 현금 영수증 수동 발급 기능입니다.
     * 현금 영수증 발급을 요청합니다.
     */
    public function issueCashReceipt(?string $paymentId = null, ?string $channelKey = null, ?string $type = null, ?string $orderName = null, ?string $currency = null, ?array $amount = null, ?string $productType = null, ?array $customer = null, ?string $paidAt = null, ?string $businessRegistrationNumber = null, ?string $paymentMethod = null, ?string $storeId = null): Model\IssueCashReceiptResponse
    {
        return $this->callOperation('issueCashReceipt', 'POST', '/cash-receipts', ['storeId' => $storeId, 'paymentId' => $paymentId, 'channelKey' => $channelKey, 'type' => $type, 'orderName' => $orderName, 'currency' => $currency, 'amount' => $amount, 'productType' => $productType, 'customer' => $customer, 'paidAt' => $paidAt, 'businessRegistrationNumber' => $businessRegistrationNumber, 'paymentMethod' => $paymentMethod], Model\IssueCashReceiptResponse::class, true);
    }

    /**
     * 현금 영수증 수동 발급 기능입니다.
     * 현금 영수증 발급을 요청합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function issueCashReceiptAsync(?string $paymentId = null, ?string $channelKey = null, ?string $type = null, ?string $orderName = null, ?string $currency = null, ?array $amount = null, ?string $productType = null, ?array $customer = null, ?string $paidAt = null, ?string $businessRegistrationNumber = null, ?string $paymentMethod = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('issueCashReceipt', 'POST', '/cash-receipts', ['storeId' => $storeId, 'paymentId' => $paymentId, 'channelKey' => $channelKey, 'type' => $type, 'orderName' => $orderName, 'currency' => $currency, 'amount' => $amount, 'productType' => $productType, 'customer' => $customer, 'paidAt' => $paidAt, 'businessRegistrationNumber' => $businessRegistrationNumber, 'paymentMethod' => $paymentMethod], Model\IssueCashReceiptResponse::class, true);
    }
}
