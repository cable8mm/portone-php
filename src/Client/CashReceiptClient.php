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
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function cancelCashReceiptByPaymentId(?string $paymentId = null, ?string $storeId = null): Model\CancelCashReceiptResponse
    {
        return $this->callOperation('cancelCashReceiptByPaymentId', 'POST', '/payments/{paymentId}/cash-receipt/cancel', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CancelCashReceiptResponse::class, false);
    }

    /**
     * 현금 영수증 취소 기능입니다.
     * 현금 영수증 취소를 요청합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function cancelCashReceiptByPaymentIdAsync(?string $paymentId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('cancelCashReceiptByPaymentId', 'POST', '/payments/{paymentId}/cash-receipt/cancel', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CancelCashReceiptResponse::class, false);
    }

    /**
     * 현금 영수증 단건 조회 기능입니다.
     * 주어진 결제 아이디에 대응되는 현금 영수증 내역을 조회합니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function getCashReceiptByPaymentId(?string $paymentId = null, ?string $storeId = null): Model\CashReceipt
    {
        return $this->callOperation('getCashReceiptByPaymentId', 'GET', '/payments/{paymentId}/cash-receipt', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CashReceipt::class, false);
    }

    /**
     * 현금 영수증 단건 조회 기능입니다.
     * 주어진 결제 아이디에 대응되는 현금 영수증 내역을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function getCashReceiptByPaymentIdAsync(?string $paymentId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getCashReceiptByPaymentId', 'GET', '/payments/{paymentId}/cash-receipt', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CashReceipt::class, false);
    }

    /**
     * 현금영수증 다건 조회 기능입니다.
     * 주어진 조건에 맞는 현금영수증들을 페이지 기반으로 조회합니다.
     *
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보: 미 입력 시 number: 0, size: 10 으로 기본값이 적용됩니다.
     * @param  array<string, mixed>|null  $sort  현금영수증 다건 조회 시 정렬 조건: 미 입력 시 sortBy: ISSUED_AT, sortOrder: DESC 으로 기본값이 적용됩니다.
     * @param  array<string, mixed>|null  $filter  현금영수증 다건 조회를 위한 입력 정보
     */
    public function getCashReceipts(?array $page = null, ?array $sort = null, ?array $filter = null): Model\GetCashReceiptsResponse
    {
        return $this->callOperation('getCashReceipts', 'GET', '/cash-receipts', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetCashReceiptsResponse::class, true);
    }

    /**
     * 현금영수증 다건 조회 기능입니다.
     * 주어진 조건에 맞는 현금영수증들을 페이지 기반으로 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보: 미 입력 시 number: 0, size: 10 으로 기본값이 적용됩니다.
     * @param  array<string, mixed>|null  $sort  현금영수증 다건 조회 시 정렬 조건: 미 입력 시 sortBy: ISSUED_AT, sortOrder: DESC 으로 기본값이 적용됩니다.
     * @param  array<string, mixed>|null  $filter  현금영수증 다건 조회를 위한 입력 정보
     */
    public function getCashReceiptsAsync(?array $page = null, ?array $sort = null, ?array $filter = null): Future
    {
        return $this->callOperationAsync('getCashReceipts', 'GET', '/cash-receipts', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetCashReceiptsResponse::class, true);
    }

    /**
     * 현금 영수증 수동 발급 기능입니다.
     * 현금 영수증 발급을 요청합니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디: 외부 결제 건에 대한 수동 발급의 경우, 아이디를 직접 채번하여 입력합니다.
     * @param  string|null  $channelKey  채널 키
     * @param  string|null  $type  발급 유형
     * @param  string|null  $orderName  주문명
     * @param  string|null  $currency  통화
     * @param  array<string, mixed>|null  $amount  금액 세부 입력 정보
     * @param  string|null  $productType  상품 유형
     * @param  array<string, mixed>|null  $customer  현금영수증 발급 시 고객 관련 입력 정보
     * @param  string|null  $paidAt  결제 일자
     * @param  string|null  $businessRegistrationNumber  사업자등록번호: 웰컴페이먼츠의 경우에만 입력합니다.
     * @param  string|null  $paymentMethod  현금영수증 발급 가능 결제 수단: 웰컴페이먼츠의 경우에만 입력합니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function issueCashReceipt(?string $paymentId = null, ?string $channelKey = null, ?string $type = null, ?string $orderName = null, ?string $currency = null, ?array $amount = null, ?string $productType = null, ?array $customer = null, ?string $paidAt = null, ?string $businessRegistrationNumber = null, ?string $paymentMethod = null, ?string $storeId = null): Model\IssueCashReceiptResponse
    {
        return $this->callOperation('issueCashReceipt', 'POST', '/cash-receipts', ['storeId' => $storeId, 'paymentId' => $paymentId, 'channelKey' => $channelKey, 'type' => $type, 'orderName' => $orderName, 'currency' => $currency, 'amount' => $amount, 'productType' => $productType, 'customer' => $customer, 'paidAt' => $paidAt, 'businessRegistrationNumber' => $businessRegistrationNumber, 'paymentMethod' => $paymentMethod], Model\IssueCashReceiptResponse::class, true);
    }

    /**
     * 현금 영수증 수동 발급 기능입니다.
     * 현금 영수증 발급을 요청합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디: 외부 결제 건에 대한 수동 발급의 경우, 아이디를 직접 채번하여 입력합니다.
     * @param  string|null  $channelKey  채널 키
     * @param  string|null  $type  발급 유형
     * @param  string|null  $orderName  주문명
     * @param  string|null  $currency  통화
     * @param  array<string, mixed>|null  $amount  금액 세부 입력 정보
     * @param  string|null  $productType  상품 유형
     * @param  array<string, mixed>|null  $customer  현금영수증 발급 시 고객 관련 입력 정보
     * @param  string|null  $paidAt  결제 일자
     * @param  string|null  $businessRegistrationNumber  사업자등록번호: 웰컴페이먼츠의 경우에만 입력합니다.
     * @param  string|null  $paymentMethod  현금영수증 발급 가능 결제 수단: 웰컴페이먼츠의 경우에만 입력합니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function issueCashReceiptAsync(?string $paymentId = null, ?string $channelKey = null, ?string $type = null, ?string $orderName = null, ?string $currency = null, ?array $amount = null, ?string $productType = null, ?array $customer = null, ?string $paidAt = null, ?string $businessRegistrationNumber = null, ?string $paymentMethod = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('issueCashReceipt', 'POST', '/cash-receipts', ['storeId' => $storeId, 'paymentId' => $paymentId, 'channelKey' => $channelKey, 'type' => $type, 'orderName' => $orderName, 'currency' => $currency, 'amount' => $amount, 'productType' => $productType, 'customer' => $customer, 'paidAt' => $paidAt, 'businessRegistrationNumber' => $businessRegistrationNumber, 'paymentMethod' => $paymentMethod], Model\IssueCashReceiptResponse::class, true);
    }
}
