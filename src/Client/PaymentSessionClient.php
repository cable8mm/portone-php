<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 결제 세션 API 작업을 제공합니다.
 */
final class PaymentSessionClient extends AbstractClient
{
    /**
     * 결제 세션 생성 기능입니다.
     * 결제 세션을 생성합니다. 호스티드 체크아웃 페이지가 생성되어 URL이 반환됩니다.
     */
    public function createPaymentSession(?string $storeId = null, ?string $paymentId = null, ?string $profileKey = null, ?string $paymentMethod = null, ?string $country = null, ?string $currency = null, ?int $totalAmount = null, ?string $orderName = null, ?string $redirectUrl = null, ?array $products = null, ?string $customerName = null, ?string $customerEmail = null, ?string $storeName = null, ?array $agreements = null, ?string $orderImageUrl = null, ?string $customData = null, ?array $colors = null, ?int $ttlSeconds = null): Model\CreatePaymentSessionResponse
    {
        return $this->callOperation('createPaymentSession', 'POST', '/payment-sessions', ['storeId' => $storeId, 'paymentId' => $paymentId, 'profileKey' => $profileKey, 'paymentMethod' => $paymentMethod, 'country' => $country, 'currency' => $currency, 'totalAmount' => $totalAmount, 'orderName' => $orderName, 'redirectUrl' => $redirectUrl, 'products' => $products, 'customerName' => $customerName, 'customerEmail' => $customerEmail, 'storeName' => $storeName, 'agreements' => $agreements, 'orderImageUrl' => $orderImageUrl, 'customData' => $customData, 'colors' => $colors, 'ttlSeconds' => $ttlSeconds], Model\CreatePaymentSessionResponse::class, true);
    }

    /**
     * 결제 세션 생성 기능입니다.
     * 결제 세션을 생성합니다. 호스티드 체크아웃 페이지가 생성되어 URL이 반환됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function createPaymentSessionAsync(?string $storeId = null, ?string $paymentId = null, ?string $profileKey = null, ?string $paymentMethod = null, ?string $country = null, ?string $currency = null, ?int $totalAmount = null, ?string $orderName = null, ?string $redirectUrl = null, ?array $products = null, ?string $customerName = null, ?string $customerEmail = null, ?string $storeName = null, ?array $agreements = null, ?string $orderImageUrl = null, ?string $customData = null, ?array $colors = null, ?int $ttlSeconds = null): Future
    {
        return $this->callOperationAsync('createPaymentSession', 'POST', '/payment-sessions', ['storeId' => $storeId, 'paymentId' => $paymentId, 'profileKey' => $profileKey, 'paymentMethod' => $paymentMethod, 'country' => $country, 'currency' => $currency, 'totalAmount' => $totalAmount, 'orderName' => $orderName, 'redirectUrl' => $redirectUrl, 'products' => $products, 'customerName' => $customerName, 'customerEmail' => $customerEmail, 'storeName' => $storeName, 'agreements' => $agreements, 'orderImageUrl' => $orderImageUrl, 'customData' => $customData, 'colors' => $colors, 'ttlSeconds' => $ttlSeconds], Model\CreatePaymentSessionResponse::class, true);
    }

    /**
     * 결제 세션 조회 기능입니다.
     * 결제 세션을 조회합니다. 인증 헤더 없이 웹 페이지에서도 접근 가능합니다.
     */
    public function getPaymentSession(?string $sessionId = null): Model\PaymentSession
    {
        return $this->callOperation('getPaymentSession', 'GET', '/payment-sessions/{sessionId}', ['sessionId' => $sessionId], Model\PaymentSession::class, false);
    }

    /**
     * 결제 세션 조회 기능입니다.
     * 결제 세션을 조회합니다. 인증 헤더 없이 웹 페이지에서도 접근 가능합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPaymentSessionAsync(?string $sessionId = null): Future
    {
        return $this->callOperationAsync('getPaymentSession', 'GET', '/payment-sessions/{sessionId}', ['sessionId' => $sessionId], Model\PaymentSession::class, false);
    }

    /**
     * 결제 세션 종료 기능입니다.
     * 결제 세션을 즉시 만료시킵니다. 이후 해당 세션으로는 결제 페이지에 접근할 수 없습니다.
     */
    public function closePaymentSession(?string $sessionId = null): Model\ClosePaymentSessionResponse
    {
        return $this->callOperation('closePaymentSession', 'POST', '/payment-sessions/{sessionId}/close', ['sessionId' => $sessionId], Model\ClosePaymentSessionResponse::class, false);
    }

    /**
     * 결제 세션 종료 기능입니다.
     * 결제 세션을 즉시 만료시킵니다. 이후 해당 세션으로는 결제 페이지에 접근할 수 없습니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function closePaymentSessionAsync(?string $sessionId = null): Future
    {
        return $this->callOperationAsync('closePaymentSession', 'POST', '/payment-sessions/{sessionId}/close', ['sessionId' => $sessionId], Model\ClosePaymentSessionResponse::class, false);
    }
}
