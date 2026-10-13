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
     *
     * @param  string|null  $storeId  상점 아이디
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $profileKey  프로필 키
     * @param  string|null  $paymentMethod  결제 수단: 지정한 경우, 정보 추가 입력이 필요하지 않은 경우에 주문서를 건너뛰고 결제로 바로 이동합니다.
     * @param  string|null  $country  국가
     * @param  string|null  $currency  통화
     * @param  int|null  $totalAmount  전체 결제 금액
     * @param  string|null  $orderName  주문명
     * @param  string|null  $redirectUrl  결제 완료 후 리다이렉트 URL: 지정하지 않으면 기본 결과 페이지가 표시됩니다.
     * @param  array<string, mixed>|null  $products  결제 세션 주문 항목
     * @param  string|null  $customerName  구매자 이름
     * @param  string|null  $customerEmail  구매자 이메일
     * @param  string|null  $storeName  상점 이름: 페이지 헤더 및 결제사 UI에 표시됩니다.
     * @param  array<string, mixed>|null  $agreements  결제 세션 약관: 구매자가 모든 약관에 동의해야 결제 버튼이 활성화됩니다.
     * @param  string|null  $orderImageUrl  주문 대표 이미지 URL
     * @param  string|null  $customData  사용자 지정 데이터: 결제 완료 후 결제 건 조회에서도 확인할 수 있습니다.
     * @param  array<string, mixed>|null  $colors  체크아웃 페이지 색 설정
     * @param  int|null  $ttlSeconds  세션 TTL (초)
     */
    public function createPaymentSession(?string $storeId = null, ?string $paymentId = null, ?string $profileKey = null, ?string $paymentMethod = null, ?string $country = null, ?string $currency = null, ?int $totalAmount = null, ?string $orderName = null, ?string $redirectUrl = null, ?array $products = null, ?string $customerName = null, ?string $customerEmail = null, ?string $storeName = null, ?array $agreements = null, ?string $orderImageUrl = null, ?string $customData = null, ?array $colors = null, ?int $ttlSeconds = null): Model\CreatePaymentSessionResponse
    {
        return $this->callOperation('createPaymentSession', 'POST', '/payment-sessions', ['storeId' => $storeId, 'paymentId' => $paymentId, 'profileKey' => $profileKey, 'paymentMethod' => $paymentMethod, 'country' => $country, 'currency' => $currency, 'totalAmount' => $totalAmount, 'orderName' => $orderName, 'redirectUrl' => $redirectUrl, 'products' => $products, 'customerName' => $customerName, 'customerEmail' => $customerEmail, 'storeName' => $storeName, 'agreements' => $agreements, 'orderImageUrl' => $orderImageUrl, 'customData' => $customData, 'colors' => $colors, 'ttlSeconds' => $ttlSeconds], Model\CreatePaymentSessionResponse::class, true);
    }

    /**
     * 결제 세션 생성 기능입니다.
     * 결제 세션을 생성합니다. 호스티드 체크아웃 페이지가 생성되어 URL이 반환됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $storeId  상점 아이디
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $profileKey  프로필 키
     * @param  string|null  $paymentMethod  결제 수단: 지정한 경우, 정보 추가 입력이 필요하지 않은 경우에 주문서를 건너뛰고 결제로 바로 이동합니다.
     * @param  string|null  $country  국가
     * @param  string|null  $currency  통화
     * @param  int|null  $totalAmount  전체 결제 금액
     * @param  string|null  $orderName  주문명
     * @param  string|null  $redirectUrl  결제 완료 후 리다이렉트 URL: 지정하지 않으면 기본 결과 페이지가 표시됩니다.
     * @param  array<string, mixed>|null  $products  결제 세션 주문 항목
     * @param  string|null  $customerName  구매자 이름
     * @param  string|null  $customerEmail  구매자 이메일
     * @param  string|null  $storeName  상점 이름: 페이지 헤더 및 결제사 UI에 표시됩니다.
     * @param  array<string, mixed>|null  $agreements  결제 세션 약관: 구매자가 모든 약관에 동의해야 결제 버튼이 활성화됩니다.
     * @param  string|null  $orderImageUrl  주문 대표 이미지 URL
     * @param  string|null  $customData  사용자 지정 데이터: 결제 완료 후 결제 건 조회에서도 확인할 수 있습니다.
     * @param  array<string, mixed>|null  $colors  체크아웃 페이지 색 설정
     * @param  int|null  $ttlSeconds  세션 TTL (초)
     */
    public function createPaymentSessionAsync(?string $storeId = null, ?string $paymentId = null, ?string $profileKey = null, ?string $paymentMethod = null, ?string $country = null, ?string $currency = null, ?int $totalAmount = null, ?string $orderName = null, ?string $redirectUrl = null, ?array $products = null, ?string $customerName = null, ?string $customerEmail = null, ?string $storeName = null, ?array $agreements = null, ?string $orderImageUrl = null, ?string $customData = null, ?array $colors = null, ?int $ttlSeconds = null): Future
    {
        return $this->callOperationAsync('createPaymentSession', 'POST', '/payment-sessions', ['storeId' => $storeId, 'paymentId' => $paymentId, 'profileKey' => $profileKey, 'paymentMethod' => $paymentMethod, 'country' => $country, 'currency' => $currency, 'totalAmount' => $totalAmount, 'orderName' => $orderName, 'redirectUrl' => $redirectUrl, 'products' => $products, 'customerName' => $customerName, 'customerEmail' => $customerEmail, 'storeName' => $storeName, 'agreements' => $agreements, 'orderImageUrl' => $orderImageUrl, 'customData' => $customData, 'colors' => $colors, 'ttlSeconds' => $ttlSeconds], Model\CreatePaymentSessionResponse::class, true);
    }

    /**
     * 결제 세션 조회 기능입니다.
     * 결제 세션을 조회합니다. 인증 헤더 없이 웹 페이지에서도 접근 가능합니다.
     *
     * @param  string|null  $sessionId  결제 세션 아이디
     */
    public function getPaymentSession(?string $sessionId = null): Model\PaymentSession
    {
        return $this->callOperation('getPaymentSession', 'GET', '/payment-sessions/{sessionId}', ['sessionId' => $sessionId], Model\PaymentSession::class, false);
    }

    /**
     * 결제 세션 조회 기능입니다.
     * 결제 세션을 조회합니다. 인증 헤더 없이 웹 페이지에서도 접근 가능합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $sessionId  결제 세션 아이디
     */
    public function getPaymentSessionAsync(?string $sessionId = null): Future
    {
        return $this->callOperationAsync('getPaymentSession', 'GET', '/payment-sessions/{sessionId}', ['sessionId' => $sessionId], Model\PaymentSession::class, false);
    }

    /**
     * 결제 세션 종료 기능입니다.
     * 결제 세션을 즉시 만료시킵니다. 이후 해당 세션으로는 결제 페이지에 접근할 수 없습니다.
     *
     * @param  string|null  $sessionId  결제 세션 아이디
     */
    public function closePaymentSession(?string $sessionId = null): Model\ClosePaymentSessionResponse
    {
        return $this->callOperation('closePaymentSession', 'POST', '/payment-sessions/{sessionId}/close', ['sessionId' => $sessionId], Model\ClosePaymentSessionResponse::class, false);
    }

    /**
     * 결제 세션 종료 기능입니다.
     * 결제 세션을 즉시 만료시킵니다. 이후 해당 세션으로는 결제 페이지에 접근할 수 없습니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $sessionId  결제 세션 아이디
     */
    public function closePaymentSessionAsync(?string $sessionId = null): Future
    {
        return $this->callOperationAsync('closePaymentSession', 'POST', '/payment-sessions/{sessionId}/close', ['sessionId' => $sessionId], Model\ClosePaymentSessionResponse::class, false);
    }
}
