<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class PaymentSessionClient extends AbstractClient
{
    public function createPaymentSession(?string $storeId = null, ?string $paymentId = null, ?string $profileKey = null, ?string $paymentMethod = null, ?string $country = null, ?string $currency = null, ?int $totalAmount = null, ?string $orderName = null, ?string $redirectUrl = null, ?array $products = null, ?string $customerName = null, ?string $customerEmail = null, ?string $storeName = null, ?array $agreements = null, ?string $orderImageUrl = null, ?string $customData = null, ?array $colors = null, ?int $ttlSeconds = null): Response\CreatePaymentSessionResponse
    {
        return $this->callOperation('createPaymentSession', 'POST', '/payment-sessions', ['storeId' => $storeId, 'paymentId' => $paymentId, 'profileKey' => $profileKey, 'paymentMethod' => $paymentMethod, 'country' => $country, 'currency' => $currency, 'totalAmount' => $totalAmount, 'orderName' => $orderName, 'redirectUrl' => $redirectUrl, 'products' => $products, 'customerName' => $customerName, 'customerEmail' => $customerEmail, 'storeName' => $storeName, 'agreements' => $agreements, 'orderImageUrl' => $orderImageUrl, 'customData' => $customData, 'colors' => $colors, 'ttlSeconds' => $ttlSeconds], Response\CreatePaymentSessionResponse::class, true);
    }

    public function createPaymentSessionAsync(?string $storeId = null, ?string $paymentId = null, ?string $profileKey = null, ?string $paymentMethod = null, ?string $country = null, ?string $currency = null, ?int $totalAmount = null, ?string $orderName = null, ?string $redirectUrl = null, ?array $products = null, ?string $customerName = null, ?string $customerEmail = null, ?string $storeName = null, ?array $agreements = null, ?string $orderImageUrl = null, ?string $customData = null, ?array $colors = null, ?int $ttlSeconds = null): Future
    {
        return $this->callOperationAsync('createPaymentSession', 'POST', '/payment-sessions', ['storeId' => $storeId, 'paymentId' => $paymentId, 'profileKey' => $profileKey, 'paymentMethod' => $paymentMethod, 'country' => $country, 'currency' => $currency, 'totalAmount' => $totalAmount, 'orderName' => $orderName, 'redirectUrl' => $redirectUrl, 'products' => $products, 'customerName' => $customerName, 'customerEmail' => $customerEmail, 'storeName' => $storeName, 'agreements' => $agreements, 'orderImageUrl' => $orderImageUrl, 'customData' => $customData, 'colors' => $colors, 'ttlSeconds' => $ttlSeconds], Response\CreatePaymentSessionResponse::class, true);
    }

    public function getPaymentSession(?string $sessionId = null): Response\PaymentSession
    {
        return $this->callOperation('getPaymentSession', 'GET', '/payment-sessions/{sessionId}', ['sessionId' => $sessionId], Response\PaymentSession::class, false);
    }

    public function getPaymentSessionAsync(?string $sessionId = null): Future
    {
        return $this->callOperationAsync('getPaymentSession', 'GET', '/payment-sessions/{sessionId}', ['sessionId' => $sessionId], Response\PaymentSession::class, false);
    }

    public function closePaymentSession(?string $sessionId = null): Response\ClosePaymentSessionResponse
    {
        return $this->callOperation('closePaymentSession', 'POST', '/payment-sessions/{sessionId}/close', ['sessionId' => $sessionId], Response\ClosePaymentSessionResponse::class, false);
    }

    public function closePaymentSessionAsync(?string $sessionId = null): Future
    {
        return $this->callOperationAsync('closePaymentSession', 'POST', '/payment-sessions/{sessionId}/close', ['sessionId' => $sessionId], Response\ClosePaymentSessionResponse::class, false);
    }
}
