<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Browser;

/**
 * 브라우저 SDK requestIssueBillingKey 호출 값을 타입으로 만듭니다.
 *
 * BrowserPaymentRequest와 같은 규칙을 따릅니다. redirectUrl은 절대 http(s) 형태를 강제하고,
 * 호출자가 복귀를 자기 기록과 대조할 수 있도록 issueId를 필수로 받습니다.
 * billingKeyMethod, windowType, card, easyPay, extra 값은 그대로 전달합니다.
 * 허용 값의 판정은 브라우저 SDK와 PG의 몫입니다.
 */
final class BrowserBillingKeyRequest
{
    /**
     * BrowserBillingKeyRequest 객체를 초기화합니다.
     *
     * @param  string  $billingKeyMethod  빌링키 발급 수단(CARD, MOBILE, EASY_PAY, PAYPAL 등)
     * @param  array<string,string>|null  $windowType  환경별 발급창 유형(pc/mobile 키)
     * @param  array<string,mixed>|null  $card  카드 발급 수단 값
     * @param  array<string,mixed>|null  $easyPay  간편결제 발급 수단 값(easyPayProvider, availablePayMethods 등)
     * @param  array<string,mixed>  $extra  문서화된 값에 더해 그대로 전달할 브라우저 SDK 값
     */
    public function __construct(
        public readonly string $storeId,
        public readonly string $channelKey,
        public readonly string $billingKeyMethod,
        public readonly string $issueId,
        public readonly string $issueName,
        public readonly string $redirectUrl,
        public readonly ?string $customerId = null,
        public readonly ?int $displayAmount = null,
        public readonly ?string $currency = null,
        public readonly ?bool $forceRedirect = null,
        public readonly ?array $windowType = null,
        public readonly ?array $card = null,
        public readonly ?array $easyPay = null,
        public readonly array $extra = [],
    ) {
        if ($issueId === '') {
            throw new \InvalidArgumentException('issueId must not be empty.');
        }

        if (! str_starts_with($redirectUrl, 'http://') && ! str_starts_with($redirectUrl, 'https://')) {
            throw new \InvalidArgumentException('redirectUrl must be an absolute http:// or https:// URL.');
        }
    }

    /**
     * 브라우저 SDK requestIssueBillingKey 파라미터 배열을 돌려줍니다.
     *
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        $parameters = [
            'storeId' => $this->storeId,
            'channelKey' => $this->channelKey,
            'billingKeyMethod' => $this->billingKeyMethod,
            'issueId' => $this->issueId,
            'issueName' => $this->issueName,
            'redirectUrl' => $this->redirectUrl,
        ];

        if ($this->customerId !== null) {
            $parameters['customer'] = ['customerId' => $this->customerId];
        }

        if ($this->displayAmount !== null) {
            $parameters['displayAmount'] = $this->displayAmount;
        }

        if ($this->currency !== null) {
            $parameters['currency'] = $this->currency;
        }

        if ($this->forceRedirect !== null) {
            $parameters['forceRedirect'] = $this->forceRedirect;
        }

        if ($this->windowType !== null) {
            $parameters['windowType'] = $this->windowType;
        }

        if ($this->card !== null) {
            $parameters['card'] = $this->card;
        }

        if ($this->easyPay !== null) {
            $parameters['easyPay'] = $this->easyPay;
        }

        // Extra keys fill the rest; documented values win on key conflicts.
        return $parameters + $this->extra;
    }
}
