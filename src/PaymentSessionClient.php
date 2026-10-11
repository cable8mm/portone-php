<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class PaymentSessionClient extends AbstractClient
{
    public function createPaymentSession(mixed $storeId = null, mixed $paymentId = null, mixed $profileKey = null, mixed $paymentMethod = null, mixed $country = null, mixed $currency = null, mixed $totalAmount = null, mixed $orderName = null, mixed $redirectUrl = null, mixed $products = null, mixed $customerName = null, mixed $customerEmail = null, mixed $storeName = null, mixed $agreements = null, mixed $orderImageUrl = null, mixed $customData = null, mixed $colors = null, mixed $ttlSeconds = null): Response\CreatePaymentSessionResponse
    {
        return $this->callOperation('createPaymentSession', 'POST', '/payment-sessions', ['storeId' => $storeId, 'paymentId' => $paymentId, 'profileKey' => $profileKey, 'paymentMethod' => $paymentMethod, 'country' => $country, 'currency' => $currency, 'totalAmount' => $totalAmount, 'orderName' => $orderName, 'redirectUrl' => $redirectUrl, 'products' => $products, 'customerName' => $customerName, 'customerEmail' => $customerEmail, 'storeName' => $storeName, 'agreements' => $agreements, 'orderImageUrl' => $orderImageUrl, 'customData' => $customData, 'colors' => $colors, 'ttlSeconds' => $ttlSeconds], Response\CreatePaymentSessionResponse::class, true);
    }

    public function createPaymentSessionAsync(mixed $storeId = null, mixed $paymentId = null, mixed $profileKey = null, mixed $paymentMethod = null, mixed $country = null, mixed $currency = null, mixed $totalAmount = null, mixed $orderName = null, mixed $redirectUrl = null, mixed $products = null, mixed $customerName = null, mixed $customerEmail = null, mixed $storeName = null, mixed $agreements = null, mixed $orderImageUrl = null, mixed $customData = null, mixed $colors = null, mixed $ttlSeconds = null): Future
    {
        return $this->callOperationAsync('createPaymentSession', 'POST', '/payment-sessions', ['storeId' => $storeId, 'paymentId' => $paymentId, 'profileKey' => $profileKey, 'paymentMethod' => $paymentMethod, 'country' => $country, 'currency' => $currency, 'totalAmount' => $totalAmount, 'orderName' => $orderName, 'redirectUrl' => $redirectUrl, 'products' => $products, 'customerName' => $customerName, 'customerEmail' => $customerEmail, 'storeName' => $storeName, 'agreements' => $agreements, 'orderImageUrl' => $orderImageUrl, 'customData' => $customData, 'colors' => $colors, 'ttlSeconds' => $ttlSeconds], Response\CreatePaymentSessionResponse::class, true);
    }

    public function getPaymentSession(mixed $sessionId = null): Response\PaymentSession
    {
        return $this->callOperation('getPaymentSession', 'GET', '/payment-sessions/{sessionId}', ['sessionId' => $sessionId], Response\PaymentSession::class, false);
    }

    public function getPaymentSessionAsync(mixed $sessionId = null): Future
    {
        return $this->callOperationAsync('getPaymentSession', 'GET', '/payment-sessions/{sessionId}', ['sessionId' => $sessionId], Response\PaymentSession::class, false);
    }

    public function closePaymentSession(mixed $sessionId = null): Response\ClosePaymentSessionResponse
    {
        return $this->callOperation('closePaymentSession', 'POST', '/payment-sessions/{sessionId}/close', ['sessionId' => $sessionId], Response\ClosePaymentSessionResponse::class, false);
    }

    public function closePaymentSessionAsync(mixed $sessionId = null): Future
    {
        return $this->callOperationAsync('closePaymentSession', 'POST', '/payment-sessions/{sessionId}/close', ['sessionId' => $sessionId], Response\ClosePaymentSessionResponse::class, false);
    }
}
