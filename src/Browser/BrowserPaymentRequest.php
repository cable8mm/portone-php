<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Browser;

/**
 * 브라우저 SDK requestPayment 호출 값을 타입으로 만듭니다.
 *
 * redirectUrl은 필수입니다. redirectUrl 없이 호출하면 모바일 결제 UI가
 * 표시되지 않을 수 있으므로, 생성자에서 절대 http(s) 형태를 강제합니다.
 * windowType 값은 그대로 전달합니다. 허용 값의 판정은 브라우저 SDK와 PG의 몫입니다.
 */
final class BrowserPaymentRequest
{
    /**
     * BrowserPaymentRequest 객체를 초기화합니다.
     *
     * @param  array<string,string>|null  $windowType  환경별 결제창 유형(pc/mobile 키)
     */
    public function __construct(
        public readonly string $storeId,
        public readonly string $channelKey,
        public readonly string $paymentId,
        public readonly string $orderName,
        public readonly int $totalAmount,
        public readonly string $redirectUrl,
        public readonly ?string $customerId = null,
        public readonly ?string $payMethod = null,
        public readonly ?string $currency = null,
        public readonly ?bool $forceRedirect = null,
        public readonly ?array $windowType = null,
    ) {
        if (! self::isAbsoluteHttpUrl($redirectUrl)) {
            throw new \InvalidArgumentException('redirectUrl must be an absolute http:// or https:// URL.');
        }
    }

    /**
     * 브라우저 SDK requestPayment 파라미터 배열을 돌려줍니다.
     *
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        $parameters = [
            'storeId' => $this->storeId,
            'channelKey' => $this->channelKey,
            'paymentId' => $this->paymentId,
            'orderName' => $this->orderName,
            'totalAmount' => $this->totalAmount,
            'redirectUrl' => $this->redirectUrl,
        ];

        if ($this->customerId !== null) {
            $parameters['customer'] = ['customerId' => $this->customerId];
        }

        if ($this->payMethod !== null) {
            $parameters['payMethod'] = $this->payMethod;
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

        return $parameters;
    }

    private static function isAbsoluteHttpUrl(string $url): bool
    {
        return str_starts_with($url, 'http://') || str_starts_with($url, 'https://');
    }
}
