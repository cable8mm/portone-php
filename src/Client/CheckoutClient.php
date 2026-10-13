<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 체크아웃 프로필 API 작업을 제공합니다.
 */
final class CheckoutClient extends AbstractClient
{
    /**
     * 체크아웃 프로필에서 결제 수단 목록 조회 기능입니다.
     * 주어진 금액 및 국가에서 사용 가능한 결제 수단 목록을 반환
     *
     * @param  string|null  $profileKey  프로필 키
     * @param  string|null  $country  국가
     * @param  string|null  $currency  통화
     * @param  int|null  $amount  결제 금액
     */
    public function evaluateCheckoutProfile(?string $profileKey = null, ?string $country = null, ?string $currency = null, ?int $amount = null): Model\EvaluateCheckoutProfileResponse
    {
        return $this->callOperation('evaluateCheckoutProfile', 'GET', '/checkout-profiles/evaluate', ['profileKey' => $profileKey, 'country' => $country, 'currency' => $currency, 'amount' => $amount], Model\EvaluateCheckoutProfileResponse::class, false);
    }

    /**
     * 체크아웃 프로필에서 결제 수단 목록 조회 기능입니다.
     * 주어진 금액 및 국가에서 사용 가능한 결제 수단 목록을 반환
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $profileKey  프로필 키
     * @param  string|null  $country  국가
     * @param  string|null  $currency  통화
     * @param  int|null  $amount  결제 금액
     */
    public function evaluateCheckoutProfileAsync(?string $profileKey = null, ?string $country = null, ?string $currency = null, ?int $amount = null): Future
    {
        return $this->callOperationAsync('evaluateCheckoutProfile', 'GET', '/checkout-profiles/evaluate', ['profileKey' => $profileKey, 'country' => $country, 'currency' => $currency, 'amount' => $amount], Model\EvaluateCheckoutProfileResponse::class, false);
    }
}
