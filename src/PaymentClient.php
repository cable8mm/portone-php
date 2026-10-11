<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

use Cable8mm\PortonePhp\Exception\ForbiddenException;
use Cable8mm\PortonePhp\Exception\InvalidRequestException;
use Cable8mm\PortonePhp\Exception\PlatformNotEnabledException;
use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\Exception\UnauthorizedException;
use Cable8mm\PortonePhp\Exception\UnknownException;
use Cable8mm\PortonePhp\Exception\UnrecognizedResponseException;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\Response\GetPaymentsResponse;
use Psr\Http\Message\ResponseInterface;

class PaymentClient extends AbstractClient
{
    public readonly BillingKeyClient $billingKey;

    public readonly CashReceiptClient $cashReceipt;

    public readonly AdditionalFeatureClient $additionalFeature;

    public readonly PaymentScheduleClient $paymentSchedule;

    public readonly PromotionClient $promotion;

    public function __construct(string $apiSecret, ?RequestExecutor $executor = null)
    {
        parent::__construct($apiSecret, $executor);
        $this->billingKey = new BillingKeyClient('', $this->executor);
        $this->cashReceipt = new CashReceiptClient('', $this->executor);
        $this->additionalFeature = new AdditionalFeatureClient('', $this->executor);
        $this->paymentSchedule = new PaymentScheduleClient('', $this->executor);
        $this->promotion = new PromotionClient('', $this->executor);
    }

    /** @param array<string,mixed>|null $page @param array<string,mixed>|null $filter */
    public function getPayments(?array $page = null, ?array $filter = null): GetPaymentsResponse
    {
        return $this->interpret(
            $this->executor->request('GET', '/payments', $this->requestOptions($page, $filter)),
        );
    }

    /** @param array<string,mixed>|null $page @param array<string,mixed>|null $filter */
    public function getPaymentsAsync(?array $page = null, ?array $filter = null): Future
    {
        $promise = $this->executor->requestAsync(
            'GET',
            '/payments',
            $this->requestOptions($page, $filter),
        )->then(fn (ResponseInterface $response): GetPaymentsResponse => $this->interpret($response));

        return new Future($promise);
    }

    /** @param array<string,mixed>|null $page @param array<string,mixed>|null $filter */
    private function requestOptions(?array $page, ?array $filter): array
    {
        $requestBody = [];
        if ($page !== null) {
            $requestBody['page'] = $page;
        }
        if ($filter !== null) {
            $requestBody['filter'] = $filter;
        }

        return [
            'query' => [
                'requestBody' => json_encode($requestBody, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES),
            ],
        ];
    }

    private function interpret(ResponseInterface $response): GetPaymentsResponse
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();

        if ($status < 200 || $status >= 300) {
            $decoded = json_decode($body, true);
            $type = is_array($decoded) && is_string($decoded['type'] ?? null) ? $decoded['type'] : null;
            $message = is_array($decoded) && is_string($decoded['message'] ?? null)
                ? $decoded['message']
                : 'PortOne returned an error response.';

            if ($type === 'INVALID_REQUEST') {
                throw new InvalidRequestException($message, $status, $body, null, $type);
            }
            if ($type === 'FORBIDDEN') {
                throw new ForbiddenException($message, $status, $body, null, $type);
            }
            if ($type === 'PLATFORM_NOT_ENABLED') {
                throw new PlatformNotEnabledException($message, $status, $body, null, $type);
            }
            if ($type === 'UNAUTHORIZED') {
                throw new UnauthorizedException($message, $status, $body, null, $type);
            }

            throw new UnknownException('getPayments', $message, $status, $body, null, $type);
        }

        try {
            $decoded = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
            if (! is_array($decoded)) {
                throw new \UnexpectedValueException('Expected a JSON object.');
            }

            return GetPaymentsResponse::fromArray($decoded);
        } catch (\Throwable $exception) {
            if ($exception instanceof PortOneException) {
                throw $exception;
            }

            throw new UnrecognizedResponseException(
                'PortOne returned an undecodable success response.',
                $status,
                $body,
                $exception,
            );
        }
    }

    public function applyEscrowLogistics(mixed $paymentId = null, mixed $sender = null, mixed $receiver = null, mixed $logistics = null, mixed $sendEmail = null, mixed $products = null, mixed $storeId = null): Response\ApplyEscrowLogisticsResponse
    {
        return $this->callOperation('applyEscrowLogistics', 'POST', '/payments/{paymentId}/escrow/logistics', ['storeId' => $storeId, 'paymentId' => $paymentId, 'sender' => $sender, 'receiver' => $receiver, 'logistics' => $logistics, 'sendEmail' => $sendEmail, 'products' => $products], Response\ApplyEscrowLogisticsResponse::class, true);
    }

    public function applyEscrowLogisticsAsync(mixed $paymentId = null, mixed $sender = null, mixed $receiver = null, mixed $logistics = null, mixed $sendEmail = null, mixed $products = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('applyEscrowLogistics', 'POST', '/payments/{paymentId}/escrow/logistics', ['storeId' => $storeId, 'paymentId' => $paymentId, 'sender' => $sender, 'receiver' => $receiver, 'logistics' => $logistics, 'sendEmail' => $sendEmail, 'products' => $products], Response\ApplyEscrowLogisticsResponse::class, true);
    }

    public function cancelPayment(mixed $paymentId = null, mixed $amount = null, mixed $taxFreeAmount = null, mixed $vatAmount = null, mixed $reason = null, mixed $requester = null, mixed $promotionDiscountRetainOption = null, mixed $currentCancellableAmount = null, mixed $refundAccount = null, mixed $refundEmail = null, mixed $skipWebhook = null, mixed $storeId = null): Response\CancelPaymentResponse
    {
        return $this->callOperation('cancelPayment', 'POST', '/payments/{paymentId}/cancel', ['storeId' => $storeId, 'paymentId' => $paymentId, 'amount' => $amount, 'taxFreeAmount' => $taxFreeAmount, 'vatAmount' => $vatAmount, 'reason' => $reason, 'requester' => $requester, 'promotionDiscountRetainOption' => $promotionDiscountRetainOption, 'currentCancellableAmount' => $currentCancellableAmount, 'refundAccount' => $refundAccount, 'refundEmail' => $refundEmail, 'skipWebhook' => $skipWebhook], Response\CancelPaymentResponse::class, true);
    }

    public function cancelPaymentAsync(mixed $paymentId = null, mixed $amount = null, mixed $taxFreeAmount = null, mixed $vatAmount = null, mixed $reason = null, mixed $requester = null, mixed $promotionDiscountRetainOption = null, mixed $currentCancellableAmount = null, mixed $refundAccount = null, mixed $refundEmail = null, mixed $skipWebhook = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('cancelPayment', 'POST', '/payments/{paymentId}/cancel', ['storeId' => $storeId, 'paymentId' => $paymentId, 'amount' => $amount, 'taxFreeAmount' => $taxFreeAmount, 'vatAmount' => $vatAmount, 'reason' => $reason, 'requester' => $requester, 'promotionDiscountRetainOption' => $promotionDiscountRetainOption, 'currentCancellableAmount' => $currentCancellableAmount, 'refundAccount' => $refundAccount, 'refundEmail' => $refundEmail, 'skipWebhook' => $skipWebhook], Response\CancelPaymentResponse::class, true);
    }

    public function capturePayment(mixed $paymentId = null, mixed $storeId = null): Response\CapturePaymentResponse
    {
        return $this->callOperation('capturePayment', 'POST', '/payments/{paymentId}/capture', ['storeId' => $storeId, 'paymentId' => $paymentId], Response\CapturePaymentResponse::class, true);
    }

    public function capturePaymentAsync(mixed $paymentId = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('capturePayment', 'POST', '/payments/{paymentId}/capture', ['storeId' => $storeId, 'paymentId' => $paymentId], Response\CapturePaymentResponse::class, true);
    }

    public function closeVirtualAccount(mixed $paymentId = null, mixed $storeId = null): Response\CloseVirtualAccountResponse
    {
        return $this->callOperation('closeVirtualAccount', 'POST', '/payments/{paymentId}/virtual-account/close', ['storeId' => $storeId, 'paymentId' => $paymentId], Response\CloseVirtualAccountResponse::class, false);
    }

    public function closeVirtualAccountAsync(mixed $paymentId = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('closeVirtualAccount', 'POST', '/payments/{paymentId}/virtual-account/close', ['storeId' => $storeId, 'paymentId' => $paymentId], Response\CloseVirtualAccountResponse::class, false);
    }

    public function confirmEscrow(mixed $paymentId = null, mixed $fromStore = null, mixed $storeId = null): Response\ConfirmEscrowResponse
    {
        return $this->callOperation('confirmEscrow', 'POST', '/payments/{paymentId}/escrow/complete', ['storeId' => $storeId, 'paymentId' => $paymentId, 'fromStore' => $fromStore], Response\ConfirmEscrowResponse::class, true);
    }

    public function confirmEscrowAsync(mixed $paymentId = null, mixed $fromStore = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('confirmEscrow', 'POST', '/payments/{paymentId}/escrow/complete', ['storeId' => $storeId, 'paymentId' => $paymentId, 'fromStore' => $fromStore], Response\ConfirmEscrowResponse::class, true);
    }

    public function confirmPayment(mixed $paymentId = null, mixed $paymentToken = null, mixed $txId = null, mixed $currency = null, mixed $totalAmount = null, mixed $taxFreeAmount = null, mixed $isTest = null, mixed $skipWebhook = null, mixed $storeId = null): Response\ConfirmedPaymentSummary
    {
        return $this->callOperation('confirmPayment', 'POST', '/payments/{paymentId}/confirm', ['storeId' => $storeId, 'paymentId' => $paymentId, 'paymentToken' => $paymentToken, 'txId' => $txId, 'currency' => $currency, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Response\ConfirmedPaymentSummary::class, true);
    }

    public function confirmPaymentAsync(mixed $paymentId = null, mixed $paymentToken = null, mixed $txId = null, mixed $currency = null, mixed $totalAmount = null, mixed $taxFreeAmount = null, mixed $isTest = null, mixed $skipWebhook = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('confirmPayment', 'POST', '/payments/{paymentId}/confirm', ['storeId' => $storeId, 'paymentId' => $paymentId, 'paymentToken' => $paymentToken, 'txId' => $txId, 'currency' => $currency, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Response\ConfirmedPaymentSummary::class, true);
    }

    public function getAllPaymentEventsByCursor(mixed $from = null, mixed $until = null, mixed $cursor = null, mixed $size = null, mixed $storeId = null): Response\GetAllPaymentEventsByCursorResponse
    {
        return $this->callOperation('getAllPaymentEventsByCursor', 'GET', '/payment-events-by-cursor', ['storeId' => $storeId, 'from' => $from, 'until' => $until, 'cursor' => $cursor, 'size' => $size], Response\GetAllPaymentEventsByCursorResponse::class, true);
    }

    public function getAllPaymentEventsByCursorAsync(mixed $from = null, mixed $until = null, mixed $cursor = null, mixed $size = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('getAllPaymentEventsByCursor', 'GET', '/payment-events-by-cursor', ['storeId' => $storeId, 'from' => $from, 'until' => $until, 'cursor' => $cursor, 'size' => $size], Response\GetAllPaymentEventsByCursorResponse::class, true);
    }

    public function getAllPaymentsByCursor(mixed $from = null, mixed $until = null, mixed $cursor = null, mixed $size = null, mixed $storeId = null): Response\GetAllPaymentsByCursorResponse
    {
        return $this->callOperation('getAllPaymentsByCursor', 'GET', '/payments-by-cursor', ['storeId' => $storeId, 'from' => $from, 'until' => $until, 'cursor' => $cursor, 'size' => $size], Response\GetAllPaymentsByCursorResponse::class, true);
    }

    public function getAllPaymentsByCursorAsync(mixed $from = null, mixed $until = null, mixed $cursor = null, mixed $size = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('getAllPaymentsByCursor', 'GET', '/payments-by-cursor', ['storeId' => $storeId, 'from' => $from, 'until' => $until, 'cursor' => $cursor, 'size' => $size], Response\GetAllPaymentsByCursorResponse::class, true);
    }

    public function getPayment(mixed $paymentId = null, mixed $storeId = null): Response\Payment
    {
        return $this->callOperation('getPayment', 'GET', '/payments/{paymentId}', ['storeId' => $storeId, 'paymentId' => $paymentId], Response\Payment::class, false);
    }

    public function getPaymentAsync(mixed $paymentId = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('getPayment', 'GET', '/payments/{paymentId}', ['storeId' => $storeId, 'paymentId' => $paymentId], Response\Payment::class, false);
    }

    public function getPaymentTransactions(mixed $paymentId = null, mixed $storeId = null): Response\GetPaymentTransactionsResponse
    {
        return $this->callOperation('getPaymentTransactions', 'GET', '/payments/{paymentId}/transactions', ['storeId' => $storeId, 'paymentId' => $paymentId], Response\GetPaymentTransactionsResponse::class, false);
    }

    public function getPaymentTransactionsAsync(mixed $paymentId = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('getPaymentTransactions', 'GET', '/payments/{paymentId}/transactions', ['storeId' => $storeId, 'paymentId' => $paymentId], Response\GetPaymentTransactionsResponse::class, false);
    }

    public function modifyEscrowLogistics(mixed $paymentId = null, mixed $sender = null, mixed $receiver = null, mixed $logistics = null, mixed $sendEmail = null, mixed $products = null, mixed $storeId = null): Response\ModifyEscrowLogisticsResponse
    {
        return $this->callOperation('modifyEscrowLogistics', 'PATCH', '/payments/{paymentId}/escrow/logistics', ['storeId' => $storeId, 'paymentId' => $paymentId, 'sender' => $sender, 'receiver' => $receiver, 'logistics' => $logistics, 'sendEmail' => $sendEmail, 'products' => $products], Response\ModifyEscrowLogisticsResponse::class, true);
    }

    public function modifyEscrowLogisticsAsync(mixed $paymentId = null, mixed $sender = null, mixed $receiver = null, mixed $logistics = null, mixed $sendEmail = null, mixed $products = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('modifyEscrowLogistics', 'PATCH', '/payments/{paymentId}/escrow/logistics', ['storeId' => $storeId, 'paymentId' => $paymentId, 'sender' => $sender, 'receiver' => $receiver, 'logistics' => $logistics, 'sendEmail' => $sendEmail, 'products' => $products], Response\ModifyEscrowLogisticsResponse::class, true);
    }

    public function payInstantly(mixed $paymentId = null, mixed $channelKey = null, mixed $channelGroupId = null, mixed $method = null, mixed $orderName = null, mixed $isCulturalExpense = null, mixed $isEscrow = null, mixed $customer = null, mixed $customData = null, mixed $amount = null, mixed $currency = null, mixed $country = null, mixed $noticeUrls = null, mixed $products = null, mixed $productCount = null, mixed $productType = null, mixed $shippingAddress = null, mixed $promotionId = null, mixed $bypass = null, mixed $skipWebhook = null, mixed $storeId = null): Response\PayInstantlyResponse
    {
        return $this->callOperation('payInstantly', 'POST', '/payments/{paymentId}/instant', ['storeId' => $storeId, 'paymentId' => $paymentId, 'channelKey' => $channelKey, 'channelGroupId' => $channelGroupId, 'method' => $method, 'orderName' => $orderName, 'isCulturalExpense' => $isCulturalExpense, 'isEscrow' => $isEscrow, 'customer' => $customer, 'customData' => $customData, 'amount' => $amount, 'currency' => $currency, 'country' => $country, 'noticeUrls' => $noticeUrls, 'products' => $products, 'productCount' => $productCount, 'productType' => $productType, 'shippingAddress' => $shippingAddress, 'promotionId' => $promotionId, 'bypass' => $bypass, 'skipWebhook' => $skipWebhook], Response\PayInstantlyResponse::class, true);
    }

    public function payInstantlyAsync(mixed $paymentId = null, mixed $channelKey = null, mixed $channelGroupId = null, mixed $method = null, mixed $orderName = null, mixed $isCulturalExpense = null, mixed $isEscrow = null, mixed $customer = null, mixed $customData = null, mixed $amount = null, mixed $currency = null, mixed $country = null, mixed $noticeUrls = null, mixed $products = null, mixed $productCount = null, mixed $productType = null, mixed $shippingAddress = null, mixed $promotionId = null, mixed $bypass = null, mixed $skipWebhook = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('payInstantly', 'POST', '/payments/{paymentId}/instant', ['storeId' => $storeId, 'paymentId' => $paymentId, 'channelKey' => $channelKey, 'channelGroupId' => $channelGroupId, 'method' => $method, 'orderName' => $orderName, 'isCulturalExpense' => $isCulturalExpense, 'isEscrow' => $isEscrow, 'customer' => $customer, 'customData' => $customData, 'amount' => $amount, 'currency' => $currency, 'country' => $country, 'noticeUrls' => $noticeUrls, 'products' => $products, 'productCount' => $productCount, 'productType' => $productType, 'shippingAddress' => $shippingAddress, 'promotionId' => $promotionId, 'bypass' => $bypass, 'skipWebhook' => $skipWebhook], Response\PayInstantlyResponse::class, true);
    }

    public function payWithBillingKey(mixed $paymentId = null, mixed $billingKey = null, mixed $channelKey = null, mixed $orderName = null, mixed $customer = null, mixed $customData = null, mixed $amount = null, mixed $currency = null, mixed $installmentMonth = null, mixed $useFreeInterestFromMerchant = null, mixed $useCardPoint = null, mixed $cashReceipt = null, mixed $country = null, mixed $noticeUrls = null, mixed $products = null, mixed $productCount = null, mixed $productType = null, mixed $shippingAddress = null, mixed $promotionId = null, mixed $locale = null, mixed $bypass = null, mixed $skipWebhook = null, mixed $storeId = null): Response\PayWithBillingKeyResponse
    {
        return $this->callOperation('payWithBillingKey', 'POST', '/payments/{paymentId}/billing-key', ['storeId' => $storeId, 'paymentId' => $paymentId, 'billingKey' => $billingKey, 'channelKey' => $channelKey, 'orderName' => $orderName, 'customer' => $customer, 'customData' => $customData, 'amount' => $amount, 'currency' => $currency, 'installmentMonth' => $installmentMonth, 'useFreeInterestFromMerchant' => $useFreeInterestFromMerchant, 'useCardPoint' => $useCardPoint, 'cashReceipt' => $cashReceipt, 'country' => $country, 'noticeUrls' => $noticeUrls, 'products' => $products, 'productCount' => $productCount, 'productType' => $productType, 'shippingAddress' => $shippingAddress, 'promotionId' => $promotionId, 'locale' => $locale, 'bypass' => $bypass, 'skipWebhook' => $skipWebhook], Response\PayWithBillingKeyResponse::class, true);
    }

    public function payWithBillingKeyAsync(mixed $paymentId = null, mixed $billingKey = null, mixed $channelKey = null, mixed $orderName = null, mixed $customer = null, mixed $customData = null, mixed $amount = null, mixed $currency = null, mixed $installmentMonth = null, mixed $useFreeInterestFromMerchant = null, mixed $useCardPoint = null, mixed $cashReceipt = null, mixed $country = null, mixed $noticeUrls = null, mixed $products = null, mixed $productCount = null, mixed $productType = null, mixed $shippingAddress = null, mixed $promotionId = null, mixed $locale = null, mixed $bypass = null, mixed $skipWebhook = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('payWithBillingKey', 'POST', '/payments/{paymentId}/billing-key', ['storeId' => $storeId, 'paymentId' => $paymentId, 'billingKey' => $billingKey, 'channelKey' => $channelKey, 'orderName' => $orderName, 'customer' => $customer, 'customData' => $customData, 'amount' => $amount, 'currency' => $currency, 'installmentMonth' => $installmentMonth, 'useFreeInterestFromMerchant' => $useFreeInterestFromMerchant, 'useCardPoint' => $useCardPoint, 'cashReceipt' => $cashReceipt, 'country' => $country, 'noticeUrls' => $noticeUrls, 'products' => $products, 'productCount' => $productCount, 'productType' => $productType, 'shippingAddress' => $shippingAddress, 'promotionId' => $promotionId, 'locale' => $locale, 'bypass' => $bypass, 'skipWebhook' => $skipWebhook], Response\PayWithBillingKeyResponse::class, true);
    }

    public function preRegisterPayment(mixed $paymentId = null, mixed $totalAmount = null, mixed $taxFreeAmount = null, mixed $currency = null, mixed $storeId = null): Response\PreRegisterPaymentResponse
    {
        return $this->callOperation('preRegisterPayment', 'POST', '/payments/{paymentId}/pre-register', ['storeId' => $storeId, 'paymentId' => $paymentId, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'currency' => $currency], Response\PreRegisterPaymentResponse::class, true);
    }

    public function preRegisterPaymentAsync(mixed $paymentId = null, mixed $totalAmount = null, mixed $taxFreeAmount = null, mixed $currency = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('preRegisterPayment', 'POST', '/payments/{paymentId}/pre-register', ['storeId' => $storeId, 'paymentId' => $paymentId, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'currency' => $currency], Response\PreRegisterPaymentResponse::class, true);
    }

    public function registerStoreReceipt(mixed $paymentId = null, mixed $items = null, mixed $storeId = null): Response\RegisterStoreReceiptResponse
    {
        return $this->callOperation('registerStoreReceipt', 'POST', '/payments/{paymentId}/register-store-receipt', ['storeId' => $storeId, 'paymentId' => $paymentId, 'items' => $items], Response\RegisterStoreReceiptResponse::class, true);
    }

    public function registerStoreReceiptAsync(mixed $paymentId = null, mixed $items = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('registerStoreReceipt', 'POST', '/payments/{paymentId}/register-store-receipt', ['storeId' => $storeId, 'paymentId' => $paymentId, 'items' => $items], Response\RegisterStoreReceiptResponse::class, true);
    }

    public function resendWebhook(mixed $paymentId = null, mixed $webhookId = null, mixed $storeId = null): Response\ResendWebhookResponse
    {
        return $this->callOperation('resendWebhook', 'POST', '/payments/{paymentId}/resend-webhook', ['storeId' => $storeId, 'paymentId' => $paymentId, 'webhookId' => $webhookId], Response\ResendWebhookResponse::class, true);
    }

    public function resendWebhookAsync(mixed $paymentId = null, mixed $webhookId = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('resendWebhook', 'POST', '/payments/{paymentId}/resend-webhook', ['storeId' => $storeId, 'paymentId' => $paymentId, 'webhookId' => $webhookId], Response\ResendWebhookResponse::class, true);
    }

    public function stopPaymentCancellation(mixed $paymentId = null, mixed $cancellationId = null, mixed $storeId = null): Response\StopPaymentCancellationResponse
    {
        return $this->callOperation('stopPaymentCancellation', 'POST', '/payments/{paymentId}/cancellations/{cancellationId}/stop', ['storeId' => $storeId, 'paymentId' => $paymentId, 'cancellationId' => $cancellationId], Response\StopPaymentCancellationResponse::class, true);
    }

    public function stopPaymentCancellationAsync(mixed $paymentId = null, mixed $cancellationId = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('stopPaymentCancellation', 'POST', '/payments/{paymentId}/cancellations/{cancellationId}/stop', ['storeId' => $storeId, 'paymentId' => $paymentId, 'cancellationId' => $cancellationId], Response\StopPaymentCancellationResponse::class, true);
    }
}
