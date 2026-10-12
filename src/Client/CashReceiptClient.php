<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

final class CashReceiptClient extends AbstractClient
{
    public function cancelCashReceiptByPaymentId(?string $paymentId = null, ?string $storeId = null): Model\CancelCashReceiptResponse
    {
        return $this->callOperation('cancelCashReceiptByPaymentId', 'POST', '/payments/{paymentId}/cash-receipt/cancel', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CancelCashReceiptResponse::class, false);
    }

    public function cancelCashReceiptByPaymentIdAsync(?string $paymentId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('cancelCashReceiptByPaymentId', 'POST', '/payments/{paymentId}/cash-receipt/cancel', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CancelCashReceiptResponse::class, false);
    }

    public function getCashReceiptByPaymentId(?string $paymentId = null, ?string $storeId = null): Model\CashReceipt
    {
        return $this->callOperation('getCashReceiptByPaymentId', 'GET', '/payments/{paymentId}/cash-receipt', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CashReceipt::class, false);
    }

    public function getCashReceiptByPaymentIdAsync(?string $paymentId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getCashReceiptByPaymentId', 'GET', '/payments/{paymentId}/cash-receipt', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CashReceipt::class, false);
    }

    public function getCashReceipts(?array $page = null, ?array $sort = null, ?array $filter = null): Model\GetCashReceiptsResponse
    {
        return $this->callOperation('getCashReceipts', 'GET', '/cash-receipts', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetCashReceiptsResponse::class, true);
    }

    public function getCashReceiptsAsync(?array $page = null, ?array $sort = null, ?array $filter = null): Future
    {
        return $this->callOperationAsync('getCashReceipts', 'GET', '/cash-receipts', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetCashReceiptsResponse::class, true);
    }

    public function issueCashReceipt(?string $paymentId = null, ?string $channelKey = null, ?string $type = null, ?string $orderName = null, ?string $currency = null, ?array $amount = null, ?string $productType = null, ?array $customer = null, ?string $paidAt = null, ?string $businessRegistrationNumber = null, ?string $paymentMethod = null, ?string $storeId = null): Model\IssueCashReceiptResponse
    {
        return $this->callOperation('issueCashReceipt', 'POST', '/cash-receipts', ['storeId' => $storeId, 'paymentId' => $paymentId, 'channelKey' => $channelKey, 'type' => $type, 'orderName' => $orderName, 'currency' => $currency, 'amount' => $amount, 'productType' => $productType, 'customer' => $customer, 'paidAt' => $paidAt, 'businessRegistrationNumber' => $businessRegistrationNumber, 'paymentMethod' => $paymentMethod], Model\IssueCashReceiptResponse::class, true);
    }

    public function issueCashReceiptAsync(?string $paymentId = null, ?string $channelKey = null, ?string $type = null, ?string $orderName = null, ?string $currency = null, ?array $amount = null, ?string $productType = null, ?array $customer = null, ?string $paidAt = null, ?string $businessRegistrationNumber = null, ?string $paymentMethod = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('issueCashReceipt', 'POST', '/cash-receipts', ['storeId' => $storeId, 'paymentId' => $paymentId, 'channelKey' => $channelKey, 'type' => $type, 'orderName' => $orderName, 'currency' => $currency, 'amount' => $amount, 'productType' => $productType, 'customer' => $customer, 'paidAt' => $paidAt, 'businessRegistrationNumber' => $businessRegistrationNumber, 'paymentMethod' => $paymentMethod], Model\IssueCashReceiptResponse::class, true);
    }
}
