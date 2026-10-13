<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\Model;
use Cable8mm\PortonePhp\Model\GetPaymentsResponse;

/**
 * 결제 API 작업과 결제 관련 하위 클라이언트에 접근할 수 있습니다.
 */
class PaymentClient extends AbstractClient
{
    public readonly BillingKeyClient $billingKey;

    public readonly CashReceiptClient $cashReceipt;

    public readonly AdditionalFeatureClient $additionalFeature;

    public readonly PaymentScheduleClient $paymentSchedule;

    public readonly PromotionClient $promotion;

    /**
     * PaymentClient 객체를 초기화합니다.
     */
    public function __construct(#[\SensitiveParameter] string $apiSecret, ?RequestExecutor $executor = null)
    {
        parent::__construct($apiSecret, $executor);
        $this->billingKey = new BillingKeyClient('', $this->executor);
        $this->cashReceipt = new CashReceiptClient('', $this->executor);
        $this->additionalFeature = new AdditionalFeatureClient('', $this->executor);
        $this->paymentSchedule = new PaymentScheduleClient('', $this->executor);
        $this->promotion = new PromotionClient('', $this->executor);
    }

    /**
     * 결제 다건 조회(페이지 기반) 기능입니다.
     * 주어진 조건에 맞는 결제 건들을 페이지 기반으로 조회합니다.
     *
     * @param  array<string, mixed>|null  $page
     * @param  array<string, mixed>|null  $filter
     */
    public function getPayments(?array $page = null, ?array $filter = null): GetPaymentsResponse
    {
        return $this->callOperation(
            'getPayments',
            'GET',
            '/payments',
            ['page' => $page, 'filter' => $filter],
            GetPaymentsResponse::class,
            true,
        );
    }

    /**
     * 결제 다건 조회(페이지 기반) 기능입니다.
     * 주어진 조건에 맞는 결제 건들을 페이지 기반으로 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  array<string, mixed>|null  $page
     * @param  array<string, mixed>|null  $filter
     */
    public function getPaymentsAsync(?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationAsync(
            'getPayments',
            'GET',
            '/payments',
            ['page' => $page, 'filter' => $filter],
            GetPaymentsResponse::class,
            true,
        );
    }

    /**
     * 에스크로 배송 정보 등록 기능입니다.
     * 에스크로 배송 정보를 등록합니다.
     */
    public function applyEscrowLogistics(?string $paymentId = null, ?array $sender = null, ?array $receiver = null, ?array $logistics = null, ?bool $sendEmail = null, ?array $products = null, ?string $storeId = null): Model\ApplyEscrowLogisticsResponse
    {
        return $this->callOperation('applyEscrowLogistics', 'POST', '/payments/{paymentId}/escrow/logistics', ['storeId' => $storeId, 'paymentId' => $paymentId, 'sender' => $sender, 'receiver' => $receiver, 'logistics' => $logistics, 'sendEmail' => $sendEmail, 'products' => $products], Model\ApplyEscrowLogisticsResponse::class, true);
    }

    /**
     * 에스크로 배송 정보 등록 기능입니다.
     * 에스크로 배송 정보를 등록합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function applyEscrowLogisticsAsync(?string $paymentId = null, ?array $sender = null, ?array $receiver = null, ?array $logistics = null, ?bool $sendEmail = null, ?array $products = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('applyEscrowLogistics', 'POST', '/payments/{paymentId}/escrow/logistics', ['storeId' => $storeId, 'paymentId' => $paymentId, 'sender' => $sender, 'receiver' => $receiver, 'logistics' => $logistics, 'sendEmail' => $sendEmail, 'products' => $products], Model\ApplyEscrowLogisticsResponse::class, true);
    }

    /**
     * 결제 취소 기능입니다.
     * 결제 취소를 요청합니다.
     */
    public function cancelPayment(?string $paymentId = null, ?int $amount = null, ?int $taxFreeAmount = null, ?int $vatAmount = null, ?string $reason = null, ?string $requester = null, ?string $promotionDiscountRetainOption = null, ?int $currentCancellableAmount = null, ?array $refundAccount = null, ?string $refundEmail = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\CancelPaymentResponse
    {
        return $this->callOperation('cancelPayment', 'POST', '/payments/{paymentId}/cancel', ['storeId' => $storeId, 'paymentId' => $paymentId, 'amount' => $amount, 'taxFreeAmount' => $taxFreeAmount, 'vatAmount' => $vatAmount, 'reason' => $reason, 'requester' => $requester, 'promotionDiscountRetainOption' => $promotionDiscountRetainOption, 'currentCancellableAmount' => $currentCancellableAmount, 'refundAccount' => $refundAccount, 'refundEmail' => $refundEmail, 'skipWebhook' => $skipWebhook], Model\CancelPaymentResponse::class, true);
    }

    /**
     * 결제 취소 기능입니다.
     * 결제 취소를 요청합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function cancelPaymentAsync(?string $paymentId = null, ?int $amount = null, ?int $taxFreeAmount = null, ?int $vatAmount = null, ?string $reason = null, ?string $requester = null, ?string $promotionDiscountRetainOption = null, ?int $currentCancellableAmount = null, ?array $refundAccount = null, ?string $refundEmail = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('cancelPayment', 'POST', '/payments/{paymentId}/cancel', ['storeId' => $storeId, 'paymentId' => $paymentId, 'amount' => $amount, 'taxFreeAmount' => $taxFreeAmount, 'vatAmount' => $vatAmount, 'reason' => $reason, 'requester' => $requester, 'promotionDiscountRetainOption' => $promotionDiscountRetainOption, 'currentCancellableAmount' => $currentCancellableAmount, 'refundAccount' => $refundAccount, 'refundEmail' => $refundEmail, 'skipWebhook' => $skipWebhook], Model\CancelPaymentResponse::class, true);
    }

    /**
     * 수동 매입 기능입니다.
     * 수동 매입을 요청합니다. PG 및 포트원과의 사전 협의가 필요합니다.
     */
    public function capturePayment(?string $paymentId = null, ?string $storeId = null): Model\CapturePaymentResponse
    {
        return $this->callOperation('capturePayment', 'POST', '/payments/{paymentId}/capture', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CapturePaymentResponse::class, true);
    }

    /**
     * 수동 매입 기능입니다.
     * 수동 매입을 요청합니다. PG 및 포트원과의 사전 협의가 필요합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function capturePaymentAsync(?string $paymentId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('capturePayment', 'POST', '/payments/{paymentId}/capture', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CapturePaymentResponse::class, true);
    }

    /**
     * 가상계좌 말소 기능입니다.
     * 발급된 가상계좌를 말소합니다.
     */
    public function closeVirtualAccount(?string $paymentId = null, ?string $storeId = null): Model\CloseVirtualAccountResponse
    {
        return $this->callOperation('closeVirtualAccount', 'POST', '/payments/{paymentId}/virtual-account/close', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CloseVirtualAccountResponse::class, false);
    }

    /**
     * 가상계좌 말소 기능입니다.
     * 발급된 가상계좌를 말소합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function closeVirtualAccountAsync(?string $paymentId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('closeVirtualAccount', 'POST', '/payments/{paymentId}/virtual-account/close', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CloseVirtualAccountResponse::class, false);
    }

    /**
     * 에스크로 구매 확정 기능입니다.
     * 에스크로 결제를 구매 확정 처리합니다
     */
    public function confirmEscrow(?string $paymentId = null, ?bool $fromStore = null, ?string $storeId = null): Model\ConfirmEscrowResponse
    {
        return $this->callOperation('confirmEscrow', 'POST', '/payments/{paymentId}/escrow/complete', ['storeId' => $storeId, 'paymentId' => $paymentId, 'fromStore' => $fromStore], Model\ConfirmEscrowResponse::class, true);
    }

    /**
     * 에스크로 구매 확정 기능입니다.
     * 에스크로 결제를 구매 확정 처리합니다
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function confirmEscrowAsync(?string $paymentId = null, ?bool $fromStore = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('confirmEscrow', 'POST', '/payments/{paymentId}/escrow/complete', ['storeId' => $storeId, 'paymentId' => $paymentId, 'fromStore' => $fromStore], Model\ConfirmEscrowResponse::class, true);
    }

    /**
     * 인증 결제 수동 승인 기능입니다.
     * 수동 승인으로 설정된 인증 결제에 대해, 결제를 완료 처리합니다.
     */
    public function confirmPayment(?string $paymentId = null, ?string $paymentToken = null, ?string $txId = null, ?string $currency = null, ?int $totalAmount = null, ?int $taxFreeAmount = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\ConfirmedPaymentSummary
    {
        return $this->callOperation('confirmPayment', 'POST', '/payments/{paymentId}/confirm', ['storeId' => $storeId, 'paymentId' => $paymentId, 'paymentToken' => $paymentToken, 'txId' => $txId, 'currency' => $currency, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedPaymentSummary::class, true);
    }

    /**
     * 인증 결제 수동 승인 기능입니다.
     * 수동 승인으로 설정된 인증 결제에 대해, 결제를 완료 처리합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function confirmPaymentAsync(?string $paymentId = null, ?string $paymentToken = null, ?string $txId = null, ?string $currency = null, ?int $totalAmount = null, ?int $taxFreeAmount = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('confirmPayment', 'POST', '/payments/{paymentId}/confirm', ['storeId' => $storeId, 'paymentId' => $paymentId, 'paymentToken' => $paymentToken, 'txId' => $txId, 'currency' => $currency, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedPaymentSummary::class, true);
    }

    /**
     * 결제 이벤트 대용량 다건 조회(커서 기반) 기능입니다.
     * 기간 내 모든 결제 이벤트를 커서 기반으로 조회합니다. 결제 이벤트의 생성일시를 기준으로 주어진 기간 내 존재하는 모든 결제 이벤트가 조회됩니다.
     */
    public function getAllPaymentEventsByCursor(?string $from = null, ?string $until = null, ?string $cursor = null, ?int $size = null, ?string $storeId = null): Model\GetAllPaymentEventsByCursorResponse
    {
        return $this->callOperation('getAllPaymentEventsByCursor', 'GET', '/payment-events-by-cursor', ['storeId' => $storeId, 'from' => $from, 'until' => $until, 'cursor' => $cursor, 'size' => $size], Model\GetAllPaymentEventsByCursorResponse::class, true);
    }

    /**
     * 결제 이벤트 대용량 다건 조회(커서 기반) 기능입니다.
     * 기간 내 모든 결제 이벤트를 커서 기반으로 조회합니다. 결제 이벤트의 생성일시를 기준으로 주어진 기간 내 존재하는 모든 결제 이벤트가 조회됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getAllPaymentEventsByCursorAsync(?string $from = null, ?string $until = null, ?string $cursor = null, ?int $size = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getAllPaymentEventsByCursor', 'GET', '/payment-events-by-cursor', ['storeId' => $storeId, 'from' => $from, 'until' => $until, 'cursor' => $cursor, 'size' => $size], Model\GetAllPaymentEventsByCursorResponse::class, true);
    }

    /**
     * 결제 대용량 다건 조회(커서 기반) 기능입니다.
     * 기간 내 모든 결제 건을 커서 기반으로 조회합니다. 결제 건의 생성일시를 기준으로 주어진 기간 내 존재하는 모든 결제 건이 조회됩니다.
     */
    public function getAllPaymentsByCursor(?string $from = null, ?string $until = null, ?string $cursor = null, ?int $size = null, ?string $storeId = null): Model\GetAllPaymentsByCursorResponse
    {
        return $this->callOperation('getAllPaymentsByCursor', 'GET', '/payments-by-cursor', ['storeId' => $storeId, 'from' => $from, 'until' => $until, 'cursor' => $cursor, 'size' => $size], Model\GetAllPaymentsByCursorResponse::class, true);
    }

    /**
     * 결제 대용량 다건 조회(커서 기반) 기능입니다.
     * 기간 내 모든 결제 건을 커서 기반으로 조회합니다. 결제 건의 생성일시를 기준으로 주어진 기간 내 존재하는 모든 결제 건이 조회됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getAllPaymentsByCursorAsync(?string $from = null, ?string $until = null, ?string $cursor = null, ?int $size = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getAllPaymentsByCursor', 'GET', '/payments-by-cursor', ['storeId' => $storeId, 'from' => $from, 'until' => $until, 'cursor' => $cursor, 'size' => $size], Model\GetAllPaymentsByCursorResponse::class, true);
    }

    /**
     * 결제 단건 조회 기능입니다.
     * 주어진 아이디에 대응되는 결제 건을 조회합니다.
     */
    public function getPayment(?string $paymentId = null, ?string $storeId = null): Model\Payment
    {
        return $this->callOperation('getPayment', 'GET', '/payments/{paymentId}', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\Payment::class, false);
    }

    /**
     * 결제 단건 조회 기능입니다.
     * 주어진 아이디에 대응되는 결제 건을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPaymentAsync(?string $paymentId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getPayment', 'GET', '/payments/{paymentId}', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\Payment::class, false);
    }

    /**
     * 결제 시도 내역 조회 기능입니다.
     * 주어진 아이디에 대응되는 결제 건의 결제 시도 내역을 조회합니다.
     */
    public function getPaymentTransactions(?string $paymentId = null, ?string $storeId = null): Model\GetPaymentTransactionsResponse
    {
        return $this->callOperation('getPaymentTransactions', 'GET', '/payments/{paymentId}/transactions', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\GetPaymentTransactionsResponse::class, false);
    }

    /**
     * 결제 시도 내역 조회 기능입니다.
     * 주어진 아이디에 대응되는 결제 건의 결제 시도 내역을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPaymentTransactionsAsync(?string $paymentId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getPaymentTransactions', 'GET', '/payments/{paymentId}/transactions', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\GetPaymentTransactionsResponse::class, false);
    }

    /**
     * 에스크로 배송 정보 수정 기능입니다.
     * 에스크로 배송 정보를 수정합니다.
     */
    public function modifyEscrowLogistics(?string $paymentId = null, ?array $sender = null, ?array $receiver = null, ?array $logistics = null, ?bool $sendEmail = null, ?array $products = null, ?string $storeId = null): Model\ModifyEscrowLogisticsResponse
    {
        return $this->callOperation('modifyEscrowLogistics', 'PATCH', '/payments/{paymentId}/escrow/logistics', ['storeId' => $storeId, 'paymentId' => $paymentId, 'sender' => $sender, 'receiver' => $receiver, 'logistics' => $logistics, 'sendEmail' => $sendEmail, 'products' => $products], Model\ModifyEscrowLogisticsResponse::class, true);
    }

    /**
     * 에스크로 배송 정보 수정 기능입니다.
     * 에스크로 배송 정보를 수정합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function modifyEscrowLogisticsAsync(?string $paymentId = null, ?array $sender = null, ?array $receiver = null, ?array $logistics = null, ?bool $sendEmail = null, ?array $products = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('modifyEscrowLogistics', 'PATCH', '/payments/{paymentId}/escrow/logistics', ['storeId' => $storeId, 'paymentId' => $paymentId, 'sender' => $sender, 'receiver' => $receiver, 'logistics' => $logistics, 'sendEmail' => $sendEmail, 'products' => $products], Model\ModifyEscrowLogisticsResponse::class, true);
    }

    /**
     * 수기 결제 기능입니다.
     * 카드 비인증 결제 또는 가상 계좌 발급을 API로 요청합니다.
     */
    public function payInstantly(?string $paymentId = null, ?string $channelKey = null, ?string $channelGroupId = null, ?array $method = null, ?string $orderName = null, ?bool $isCulturalExpense = null, ?bool $isEscrow = null, ?array $customer = null, ?string $customData = null, ?array $amount = null, ?string $currency = null, ?string $country = null, ?array $noticeUrls = null, ?array $products = null, ?int $productCount = null, ?string $productType = null, ?array $shippingAddress = null, ?string $promotionId = null, ?array $bypass = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\PayInstantlyResponse
    {
        return $this->callOperation('payInstantly', 'POST', '/payments/{paymentId}/instant', ['storeId' => $storeId, 'paymentId' => $paymentId, 'channelKey' => $channelKey, 'channelGroupId' => $channelGroupId, 'method' => $method, 'orderName' => $orderName, 'isCulturalExpense' => $isCulturalExpense, 'isEscrow' => $isEscrow, 'customer' => $customer, 'customData' => $customData, 'amount' => $amount, 'currency' => $currency, 'country' => $country, 'noticeUrls' => $noticeUrls, 'products' => $products, 'productCount' => $productCount, 'productType' => $productType, 'shippingAddress' => $shippingAddress, 'promotionId' => $promotionId, 'bypass' => $bypass, 'skipWebhook' => $skipWebhook], Model\PayInstantlyResponse::class, true);
    }

    /**
     * 수기 결제 기능입니다.
     * 카드 비인증 결제 또는 가상 계좌 발급을 API로 요청합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function payInstantlyAsync(?string $paymentId = null, ?string $channelKey = null, ?string $channelGroupId = null, ?array $method = null, ?string $orderName = null, ?bool $isCulturalExpense = null, ?bool $isEscrow = null, ?array $customer = null, ?string $customData = null, ?array $amount = null, ?string $currency = null, ?string $country = null, ?array $noticeUrls = null, ?array $products = null, ?int $productCount = null, ?string $productType = null, ?array $shippingAddress = null, ?string $promotionId = null, ?array $bypass = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('payInstantly', 'POST', '/payments/{paymentId}/instant', ['storeId' => $storeId, 'paymentId' => $paymentId, 'channelKey' => $channelKey, 'channelGroupId' => $channelGroupId, 'method' => $method, 'orderName' => $orderName, 'isCulturalExpense' => $isCulturalExpense, 'isEscrow' => $isEscrow, 'customer' => $customer, 'customData' => $customData, 'amount' => $amount, 'currency' => $currency, 'country' => $country, 'noticeUrls' => $noticeUrls, 'products' => $products, 'productCount' => $productCount, 'productType' => $productType, 'shippingAddress' => $shippingAddress, 'promotionId' => $promotionId, 'bypass' => $bypass, 'skipWebhook' => $skipWebhook], Model\PayInstantlyResponse::class, true);
    }

    /**
     * 빌링키 결제 기능입니다.
     * 빌링키로 결제를 진행합니다.
     */
    public function payWithBillingKey(?string $paymentId = null, ?string $billingKey = null, ?string $channelKey = null, ?string $orderName = null, ?array $customer = null, ?string $customData = null, ?array $amount = null, ?string $currency = null, ?int $installmentMonth = null, ?bool $useFreeInterestFromMerchant = null, ?bool $useCardPoint = null, ?array $cashReceipt = null, ?string $country = null, ?array $noticeUrls = null, ?array $products = null, ?int $productCount = null, ?string $productType = null, ?array $shippingAddress = null, ?string $promotionId = null, ?string $locale = null, ?array $bypass = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\PayWithBillingKeyResponse
    {
        return $this->callOperation('payWithBillingKey', 'POST', '/payments/{paymentId}/billing-key', ['storeId' => $storeId, 'paymentId' => $paymentId, 'billingKey' => $billingKey, 'channelKey' => $channelKey, 'orderName' => $orderName, 'customer' => $customer, 'customData' => $customData, 'amount' => $amount, 'currency' => $currency, 'installmentMonth' => $installmentMonth, 'useFreeInterestFromMerchant' => $useFreeInterestFromMerchant, 'useCardPoint' => $useCardPoint, 'cashReceipt' => $cashReceipt, 'country' => $country, 'noticeUrls' => $noticeUrls, 'products' => $products, 'productCount' => $productCount, 'productType' => $productType, 'shippingAddress' => $shippingAddress, 'promotionId' => $promotionId, 'locale' => $locale, 'bypass' => $bypass, 'skipWebhook' => $skipWebhook], Model\PayWithBillingKeyResponse::class, true);
    }

    /**
     * 빌링키 결제 기능입니다.
     * 빌링키로 결제를 진행합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function payWithBillingKeyAsync(?string $paymentId = null, ?string $billingKey = null, ?string $channelKey = null, ?string $orderName = null, ?array $customer = null, ?string $customData = null, ?array $amount = null, ?string $currency = null, ?int $installmentMonth = null, ?bool $useFreeInterestFromMerchant = null, ?bool $useCardPoint = null, ?array $cashReceipt = null, ?string $country = null, ?array $noticeUrls = null, ?array $products = null, ?int $productCount = null, ?string $productType = null, ?array $shippingAddress = null, ?string $promotionId = null, ?string $locale = null, ?array $bypass = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('payWithBillingKey', 'POST', '/payments/{paymentId}/billing-key', ['storeId' => $storeId, 'paymentId' => $paymentId, 'billingKey' => $billingKey, 'channelKey' => $channelKey, 'orderName' => $orderName, 'customer' => $customer, 'customData' => $customData, 'amount' => $amount, 'currency' => $currency, 'installmentMonth' => $installmentMonth, 'useFreeInterestFromMerchant' => $useFreeInterestFromMerchant, 'useCardPoint' => $useCardPoint, 'cashReceipt' => $cashReceipt, 'country' => $country, 'noticeUrls' => $noticeUrls, 'products' => $products, 'productCount' => $productCount, 'productType' => $productType, 'shippingAddress' => $shippingAddress, 'promotionId' => $promotionId, 'locale' => $locale, 'bypass' => $bypass, 'skipWebhook' => $skipWebhook], Model\PayWithBillingKeyResponse::class, true);
    }

    /**
     * 결제 정보 사전 등록 기능입니다.
     * 결제 정보를 사전 등록합니다.
     */
    public function preRegisterPayment(?string $paymentId = null, ?int $totalAmount = null, ?int $taxFreeAmount = null, ?string $currency = null, ?string $storeId = null): Model\PreRegisterPaymentResponse
    {
        return $this->callOperation('preRegisterPayment', 'POST', '/payments/{paymentId}/pre-register', ['storeId' => $storeId, 'paymentId' => $paymentId, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'currency' => $currency], Model\PreRegisterPaymentResponse::class, true);
    }

    /**
     * 결제 정보 사전 등록 기능입니다.
     * 결제 정보를 사전 등록합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function preRegisterPaymentAsync(?string $paymentId = null, ?int $totalAmount = null, ?int $taxFreeAmount = null, ?string $currency = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('preRegisterPayment', 'POST', '/payments/{paymentId}/pre-register', ['storeId' => $storeId, 'paymentId' => $paymentId, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'currency' => $currency], Model\PreRegisterPaymentResponse::class, true);
    }

    /**
     * 영수증 내 하위 상점 거래 등록 기능입니다.
     * 결제 내역 매출전표에 하위 상점의 거래를 등록합니다.
지원되는 PG사:
KG이니시스(이용 전 콘솔 -> 결제연동 탭에서 INIApi Key 등록 필요)
     */
    public function registerStoreReceipt(?string $paymentId = null, ?array $items = null, ?string $storeId = null): Model\RegisterStoreReceiptResponse
    {
        return $this->callOperation('registerStoreReceipt', 'POST', '/payments/{paymentId}/register-store-receipt', ['storeId' => $storeId, 'paymentId' => $paymentId, 'items' => $items], Model\RegisterStoreReceiptResponse::class, true);
    }

    /**
     * 영수증 내 하위 상점 거래 등록 기능입니다.
     * 결제 내역 매출전표에 하위 상점의 거래를 등록합니다.
지원되는 PG사:
KG이니시스(이용 전 콘솔 -> 결제연동 탭에서 INIApi Key 등록 필요)
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function registerStoreReceiptAsync(?string $paymentId = null, ?array $items = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('registerStoreReceipt', 'POST', '/payments/{paymentId}/register-store-receipt', ['storeId' => $storeId, 'paymentId' => $paymentId, 'items' => $items], Model\RegisterStoreReceiptResponse::class, true);
    }

    /**
     * 웹훅 재발송 기능입니다.
     * 웹훅을 재발송합니다.
     */
    public function resendWebhook(?string $paymentId = null, ?string $webhookId = null, ?string $storeId = null): Model\ResendWebhookResponse
    {
        return $this->callOperation('resendWebhook', 'POST', '/payments/{paymentId}/resend-webhook', ['storeId' => $storeId, 'paymentId' => $paymentId, 'webhookId' => $webhookId], Model\ResendWebhookResponse::class, true);
    }

    /**
     * 웹훅 재발송 기능입니다.
     * 웹훅을 재발송합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function resendWebhookAsync(?string $paymentId = null, ?string $webhookId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('resendWebhook', 'POST', '/payments/{paymentId}/resend-webhook', ['storeId' => $storeId, 'paymentId' => $paymentId, 'webhookId' => $webhookId], Model\ResendWebhookResponse::class, true);
    }

    /**
     * 결제 취소 요청 취소 기능입니다.
     * 비동기적으로 수행되는 결제 취소 요청을 취소합니다.
Triple-A에서만 사용됩니다.
     */
    public function stopPaymentCancellation(?string $paymentId = null, ?string $cancellationId = null, ?string $storeId = null): Model\StopPaymentCancellationResponse
    {
        return $this->callOperation('stopPaymentCancellation', 'POST', '/payments/{paymentId}/cancellations/{cancellationId}/stop', ['storeId' => $storeId, 'paymentId' => $paymentId, 'cancellationId' => $cancellationId], Model\StopPaymentCancellationResponse::class, true);
    }

    /**
     * 결제 취소 요청 취소 기능입니다.
     * 비동기적으로 수행되는 결제 취소 요청을 취소합니다.
Triple-A에서만 사용됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function stopPaymentCancellationAsync(?string $paymentId = null, ?string $cancellationId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('stopPaymentCancellation', 'POST', '/payments/{paymentId}/cancellations/{cancellationId}/stop', ['storeId' => $storeId, 'paymentId' => $paymentId, 'cancellationId' => $cancellationId], Model\StopPaymentCancellationResponse::class, true);
    }
}
