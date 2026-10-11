<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class CashReceiptClient extends AbstractClient
{
    public function cancelCashReceiptByPaymentId(mixed $paymentId = null, mixed $storeId = null): Response\CancelCashReceiptResponse
    {
        return $this->callOperation('cancelCashReceiptByPaymentId', 'POST', '/payments/{paymentId}/cash-receipt/cancel', ['storeId' => $storeId, 'paymentId' => $paymentId], Response\CancelCashReceiptResponse::class, false);
    }

    public function cancelCashReceiptByPaymentIdAsync(mixed $paymentId = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('cancelCashReceiptByPaymentId', 'POST', '/payments/{paymentId}/cash-receipt/cancel', ['storeId' => $storeId, 'paymentId' => $paymentId], Response\CancelCashReceiptResponse::class, false);
    }

    public function getCashReceiptByPaymentId(mixed $paymentId = null, mixed $storeId = null): Response\CashReceipt
    {
        return $this->callOperation('getCashReceiptByPaymentId', 'GET', '/payments/{paymentId}/cash-receipt', ['storeId' => $storeId, 'paymentId' => $paymentId], Response\CashReceipt::class, false);
    }

    public function getCashReceiptByPaymentIdAsync(mixed $paymentId = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('getCashReceiptByPaymentId', 'GET', '/payments/{paymentId}/cash-receipt', ['storeId' => $storeId, 'paymentId' => $paymentId], Response\CashReceipt::class, false);
    }

    public function getCashReceipts(mixed $page = null, mixed $sort = null, mixed $filter = null): Response\GetCashReceiptsResponse
    {
        return $this->callOperation('getCashReceipts', 'GET', '/cash-receipts', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Response\GetCashReceiptsResponse::class, true);
    }

    public function getCashReceiptsAsync(mixed $page = null, mixed $sort = null, mixed $filter = null): Future
    {
        return $this->callOperationAsync('getCashReceipts', 'GET', '/cash-receipts', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Response\GetCashReceiptsResponse::class, true);
    }

    public function issueCashReceipt(mixed $paymentId = null, mixed $channelKey = null, mixed $type = null, mixed $orderName = null, mixed $currency = null, mixed $amount = null, mixed $productType = null, mixed $customer = null, mixed $paidAt = null, mixed $businessRegistrationNumber = null, mixed $paymentMethod = null, mixed $storeId = null): Response\IssueCashReceiptResponse
    {
        return $this->callOperation('issueCashReceipt', 'POST', '/cash-receipts', ['storeId' => $storeId, 'paymentId' => $paymentId, 'channelKey' => $channelKey, 'type' => $type, 'orderName' => $orderName, 'currency' => $currency, 'amount' => $amount, 'productType' => $productType, 'customer' => $customer, 'paidAt' => $paidAt, 'businessRegistrationNumber' => $businessRegistrationNumber, 'paymentMethod' => $paymentMethod], Response\IssueCashReceiptResponse::class, true);
    }

    public function issueCashReceiptAsync(mixed $paymentId = null, mixed $channelKey = null, mixed $type = null, mixed $orderName = null, mixed $currency = null, mixed $amount = null, mixed $productType = null, mixed $customer = null, mixed $paidAt = null, mixed $businessRegistrationNumber = null, mixed $paymentMethod = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('issueCashReceipt', 'POST', '/cash-receipts', ['storeId' => $storeId, 'paymentId' => $paymentId, 'channelKey' => $channelKey, 'type' => $type, 'orderName' => $orderName, 'currency' => $currency, 'amount' => $amount, 'productType' => $productType, 'customer' => $customer, 'paidAt' => $paidAt, 'businessRegistrationNumber' => $businessRegistrationNumber, 'paymentMethod' => $paymentMethod], Response\IssueCashReceiptResponse::class, true);
    }
}
