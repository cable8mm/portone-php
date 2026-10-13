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
     *
     * @param  string  $apiSecret  PortOne V2 API 요청 인증에 사용하는 API Secret입니다.
     * @param  RequestExecutor|null  $executor  부모 클라이언트와 공유하는 요청 실행기입니다.
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
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보: 미 입력 시 number = 0, size = 10 으로 기본값이 적용됩니다. (number + 1) * size가 60,000을 초과할 수 없습니다.
     * @param  array<string, mixed>|null  $filter  결제 다건 조회를 위한 입력 정보: V1 결제 건의 경우 일부 필드에 대해 필터가 적용되지 않을 수 있습니다.
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
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보: 미 입력 시 number = 0, size = 10 으로 기본값이 적용됩니다. (number + 1) * size가 60,000을 초과할 수 없습니다.
     * @param  array<string, mixed>|null  $filter  결제 다건 조회를 위한 입력 정보: V1 결제 건의 경우 일부 필드에 대해 필터가 적용되지 않을 수 있습니다.
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
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  array<string, mixed>|null  $sender  에스크로 발송자 정보
     * @param  array<string, mixed>|null  $receiver  에스크로 수취인 정보
     * @param  array<string, mixed>|null  $logistics  배송정보
     * @param  bool|null  $sendEmail  이메일 알림 전송 여부: 에스크로 구매 확정 시 이메일로 알림을 보낼지 여부입니다.
     * @param  array<string, mixed>|null  $products  상품 정보
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function applyEscrowLogistics(?string $paymentId = null, ?array $sender = null, ?array $receiver = null, ?array $logistics = null, ?bool $sendEmail = null, ?array $products = null, ?string $storeId = null): Model\ApplyEscrowLogisticsResponse
    {
        return $this->callOperation('applyEscrowLogistics', 'POST', '/payments/{paymentId}/escrow/logistics', ['storeId' => $storeId, 'paymentId' => $paymentId, 'sender' => $sender, 'receiver' => $receiver, 'logistics' => $logistics, 'sendEmail' => $sendEmail, 'products' => $products], Model\ApplyEscrowLogisticsResponse::class, true);
    }

    /**
     * 에스크로 배송 정보 등록 기능입니다.
     * 에스크로 배송 정보를 등록합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  array<string, mixed>|null  $sender  에스크로 발송자 정보
     * @param  array<string, mixed>|null  $receiver  에스크로 수취인 정보
     * @param  array<string, mixed>|null  $logistics  배송정보
     * @param  bool|null  $sendEmail  이메일 알림 전송 여부: 에스크로 구매 확정 시 이메일로 알림을 보낼지 여부입니다.
     * @param  array<string, mixed>|null  $products  상품 정보
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function applyEscrowLogisticsAsync(?string $paymentId = null, ?array $sender = null, ?array $receiver = null, ?array $logistics = null, ?bool $sendEmail = null, ?array $products = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('applyEscrowLogistics', 'POST', '/payments/{paymentId}/escrow/logistics', ['storeId' => $storeId, 'paymentId' => $paymentId, 'sender' => $sender, 'receiver' => $receiver, 'logistics' => $logistics, 'sendEmail' => $sendEmail, 'products' => $products], Model\ApplyEscrowLogisticsResponse::class, true);
    }

    /**
     * 결제 취소 기능입니다.
     * 결제 취소를 요청합니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  int|null  $amount  취소 총 금액: 값을 입력하지 않으면 전액 취소됩니다.
     * @param  int|null  $taxFreeAmount  취소 금액 중 면세 금액: 값을 입력하지 않으면 전액 과세 취소됩니다.
     * @param  int|null  $vatAmount  취소 금액 중 부가세액: 값을 입력하지 않으면 자동 계산됩니다.
     * @param  string|null  $reason  취소 사유
     * @param  string|null  $requester  결제 취소 요청 주체: 고객에 의한 취소일 경우 Customer, 관리자에 의한 취소일 경우 Admin으로 입력합니다.
     * @param  string|null  $promotionDiscountRetainOption  프로모션 할인율 유지 옵션: 프로모션이 적용된 결제를 부분 취소하는 경우, 최초 할인율을 유지할지 여부를 선택할 수 있습니다. RETAIN 으로 설정 시, 최초 할인율을 유지할 수 있도록 취소 금액이 조정됩니다. RELEASE 으로 설정 시, 취소 후 남은 금액이 속한 구간에 맞게 프로모션 할인이 새롭게 적용됩니다. 값을 입력하지 않으면 RELEASE 로 취급합니다.
     * @param  int|null  $currentCancellableAmount  결제 건의 취소 가능 잔액: 본 취소 요청 이전의 취소 가능 잔액으로써, 값을 입력하면 잔액이 일치하는 경우에만 취소가 진행됩니다. 값을 입력하지 않으면 별도의 검증 처리를 수행하지 않습니다.
     * @param  array<string, mixed>|null  $refundAccount  고객 정보 입력 형식: 계좌 환불일 경우 입력합니다. 계좌 환불이 필요한 경우는 가상계좌 환불, 휴대폰 익월 환불 등이 있습니다.
     * @param  string|null  $refundEmail  환불 이메일: Triple-A 결제 환불에 필요합니다. 해당 이메일로 환불 안내가 발송됩니다.
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 취소가 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function cancelPayment(?string $paymentId = null, ?int $amount = null, ?int $taxFreeAmount = null, ?int $vatAmount = null, ?string $reason = null, ?string $requester = null, ?string $promotionDiscountRetainOption = null, ?int $currentCancellableAmount = null, ?array $refundAccount = null, ?string $refundEmail = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\CancelPaymentResponse
    {
        return $this->callOperation('cancelPayment', 'POST', '/payments/{paymentId}/cancel', ['storeId' => $storeId, 'paymentId' => $paymentId, 'amount' => $amount, 'taxFreeAmount' => $taxFreeAmount, 'vatAmount' => $vatAmount, 'reason' => $reason, 'requester' => $requester, 'promotionDiscountRetainOption' => $promotionDiscountRetainOption, 'currentCancellableAmount' => $currentCancellableAmount, 'refundAccount' => $refundAccount, 'refundEmail' => $refundEmail, 'skipWebhook' => $skipWebhook], Model\CancelPaymentResponse::class, true);
    }

    /**
     * 결제 취소 기능입니다.
     * 결제 취소를 요청합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  int|null  $amount  취소 총 금액: 값을 입력하지 않으면 전액 취소됩니다.
     * @param  int|null  $taxFreeAmount  취소 금액 중 면세 금액: 값을 입력하지 않으면 전액 과세 취소됩니다.
     * @param  int|null  $vatAmount  취소 금액 중 부가세액: 값을 입력하지 않으면 자동 계산됩니다.
     * @param  string|null  $reason  취소 사유
     * @param  string|null  $requester  결제 취소 요청 주체: 고객에 의한 취소일 경우 Customer, 관리자에 의한 취소일 경우 Admin으로 입력합니다.
     * @param  string|null  $promotionDiscountRetainOption  프로모션 할인율 유지 옵션: 프로모션이 적용된 결제를 부분 취소하는 경우, 최초 할인율을 유지할지 여부를 선택할 수 있습니다. RETAIN 으로 설정 시, 최초 할인율을 유지할 수 있도록 취소 금액이 조정됩니다. RELEASE 으로 설정 시, 취소 후 남은 금액이 속한 구간에 맞게 프로모션 할인이 새롭게 적용됩니다. 값을 입력하지 않으면 RELEASE 로 취급합니다.
     * @param  int|null  $currentCancellableAmount  결제 건의 취소 가능 잔액: 본 취소 요청 이전의 취소 가능 잔액으로써, 값을 입력하면 잔액이 일치하는 경우에만 취소가 진행됩니다. 값을 입력하지 않으면 별도의 검증 처리를 수행하지 않습니다.
     * @param  array<string, mixed>|null  $refundAccount  고객 정보 입력 형식: 계좌 환불일 경우 입력합니다. 계좌 환불이 필요한 경우는 가상계좌 환불, 휴대폰 익월 환불 등이 있습니다.
     * @param  string|null  $refundEmail  환불 이메일: Triple-A 결제 환불에 필요합니다. 해당 이메일로 환불 안내가 발송됩니다.
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 취소가 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function cancelPaymentAsync(?string $paymentId = null, ?int $amount = null, ?int $taxFreeAmount = null, ?int $vatAmount = null, ?string $reason = null, ?string $requester = null, ?string $promotionDiscountRetainOption = null, ?int $currentCancellableAmount = null, ?array $refundAccount = null, ?string $refundEmail = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('cancelPayment', 'POST', '/payments/{paymentId}/cancel', ['storeId' => $storeId, 'paymentId' => $paymentId, 'amount' => $amount, 'taxFreeAmount' => $taxFreeAmount, 'vatAmount' => $vatAmount, 'reason' => $reason, 'requester' => $requester, 'promotionDiscountRetainOption' => $promotionDiscountRetainOption, 'currentCancellableAmount' => $currentCancellableAmount, 'refundAccount' => $refundAccount, 'refundEmail' => $refundEmail, 'skipWebhook' => $skipWebhook], Model\CancelPaymentResponse::class, true);
    }

    /**
     * 수동 매입 기능입니다.
     * 수동 매입을 요청합니다. PG 및 포트원과의 사전 협의가 필요합니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function capturePayment(?string $paymentId = null, ?string $storeId = null): Model\CapturePaymentResponse
    {
        return $this->callOperation('capturePayment', 'POST', '/payments/{paymentId}/capture', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CapturePaymentResponse::class, true);
    }

    /**
     * 수동 매입 기능입니다.
     * 수동 매입을 요청합니다. PG 및 포트원과의 사전 협의가 필요합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function capturePaymentAsync(?string $paymentId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('capturePayment', 'POST', '/payments/{paymentId}/capture', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CapturePaymentResponse::class, true);
    }

    /**
     * 가상계좌 말소 기능입니다.
     * 발급된 가상계좌를 말소합니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function closeVirtualAccount(?string $paymentId = null, ?string $storeId = null): Model\CloseVirtualAccountResponse
    {
        return $this->callOperation('closeVirtualAccount', 'POST', '/payments/{paymentId}/virtual-account/close', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CloseVirtualAccountResponse::class, false);
    }

    /**
     * 가상계좌 말소 기능입니다.
     * 발급된 가상계좌를 말소합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function closeVirtualAccountAsync(?string $paymentId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('closeVirtualAccount', 'POST', '/payments/{paymentId}/virtual-account/close', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\CloseVirtualAccountResponse::class, false);
    }

    /**
     * 에스크로 구매 확정 기능입니다.
     * 에스크로 결제를 구매 확정 처리합니다
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  bool|null  $fromStore  확인 주체가 상점인지 여부: 구매확정요청 주체가 고객사 관리자인지 구매자인지 구분하기 위한 필드입니다. 네이버페이 전용 파라미터이며, 구분이 모호한 경우 고객사 관리자(true)로 입력합니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function confirmEscrow(?string $paymentId = null, ?bool $fromStore = null, ?string $storeId = null): Model\ConfirmEscrowResponse
    {
        return $this->callOperation('confirmEscrow', 'POST', '/payments/{paymentId}/escrow/complete', ['storeId' => $storeId, 'paymentId' => $paymentId, 'fromStore' => $fromStore], Model\ConfirmEscrowResponse::class, true);
    }

    /**
     * 에스크로 구매 확정 기능입니다.
     * 에스크로 결제를 구매 확정 처리합니다
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  bool|null  $fromStore  확인 주체가 상점인지 여부: 구매확정요청 주체가 고객사 관리자인지 구매자인지 구분하기 위한 필드입니다. 네이버페이 전용 파라미터이며, 구분이 모호한 경우 고객사 관리자(true)로 입력합니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function confirmEscrowAsync(?string $paymentId = null, ?bool $fromStore = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('confirmEscrow', 'POST', '/payments/{paymentId}/escrow/complete', ['storeId' => $storeId, 'paymentId' => $paymentId, 'fromStore' => $fromStore], Model\ConfirmEscrowResponse::class, true);
    }

    /**
     * 인증 결제 수동 승인 기능입니다.
     * 수동 승인으로 설정된 인증 결제에 대해, 결제를 완료 처리합니다.
     *
     * @param  string|null  $paymentId  결제 아이디
     * @param  string|null  $paymentToken  결제 토큰: 인증 완료 시 발급된 토큰입니다.
     * @param  string|null  $txId  검증용 파라미터로, 결제 시도 아이디와 일치하지 않을 경우 오류가 반환됩니다.
     * @param  string|null  $currency  통화: 검증용 파라미터로, 결제 건 화폐와 일치하지 않을 경우 오류가 반환됩니다. 값 전달을 권장합니다.
     * @param  int|null  $totalAmount  결제 금액: 검증용 파라미터로, 결제 건 총 금액과 일치하지 않을 경우 오류가 반환됩니다. 값 전달을 권장합니다.
     * @param  int|null  $taxFreeAmount  검증용 파라미터로, 결제 건 면세 금액과 일치하지 않을 경우 오류가 반환됩니다.
     * @param  bool|null  $isTest  테스트 결제 여부: 검증용 파라미터로, 결제 건 테스트 여부와 일치하지 않을 경우 오류가 반환됩니다. 값 전달을 권장합니다.
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 결제가 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다. 가상계좌 입금 완료 등 외부 이벤트로 결제가 완료되는 경우 발생하는 웹훅은 스킵되지 않습니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function confirmPayment(?string $paymentId = null, ?string $paymentToken = null, ?string $txId = null, ?string $currency = null, ?int $totalAmount = null, ?int $taxFreeAmount = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\ConfirmedPaymentSummary
    {
        return $this->callOperation('confirmPayment', 'POST', '/payments/{paymentId}/confirm', ['storeId' => $storeId, 'paymentId' => $paymentId, 'paymentToken' => $paymentToken, 'txId' => $txId, 'currency' => $currency, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedPaymentSummary::class, true);
    }

    /**
     * 인증 결제 수동 승인 기능입니다.
     * 수동 승인으로 설정된 인증 결제에 대해, 결제를 완료 처리합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  결제 아이디
     * @param  string|null  $paymentToken  결제 토큰: 인증 완료 시 발급된 토큰입니다.
     * @param  string|null  $txId  검증용 파라미터로, 결제 시도 아이디와 일치하지 않을 경우 오류가 반환됩니다.
     * @param  string|null  $currency  통화: 검증용 파라미터로, 결제 건 화폐와 일치하지 않을 경우 오류가 반환됩니다. 값 전달을 권장합니다.
     * @param  int|null  $totalAmount  결제 금액: 검증용 파라미터로, 결제 건 총 금액과 일치하지 않을 경우 오류가 반환됩니다. 값 전달을 권장합니다.
     * @param  int|null  $taxFreeAmount  검증용 파라미터로, 결제 건 면세 금액과 일치하지 않을 경우 오류가 반환됩니다.
     * @param  bool|null  $isTest  테스트 결제 여부: 검증용 파라미터로, 결제 건 테스트 여부와 일치하지 않을 경우 오류가 반환됩니다. 값 전달을 권장합니다.
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 결제가 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다. 가상계좌 입금 완료 등 외부 이벤트로 결제가 완료되는 경우 발생하는 웹훅은 스킵되지 않습니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function confirmPaymentAsync(?string $paymentId = null, ?string $paymentToken = null, ?string $txId = null, ?string $currency = null, ?int $totalAmount = null, ?int $taxFreeAmount = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('confirmPayment', 'POST', '/payments/{paymentId}/confirm', ['storeId' => $storeId, 'paymentId' => $paymentId, 'paymentToken' => $paymentToken, 'txId' => $txId, 'currency' => $currency, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedPaymentSummary::class, true);
    }

    /**
     * 결제 이벤트 대용량 다건 조회(커서 기반) 기능입니다.
     * 기간 내 모든 결제 이벤트를 커서 기반으로 조회합니다. 결제 이벤트의 생성일시를 기준으로 주어진 기간 내 존재하는 모든 결제 이벤트가 조회됩니다.
     *
     * @param  string|null  $from  결제 이벤트 생성시점 범위 조건의 시작: 값을 입력하지 않으면 end의 90일 전으로 설정됩니다.
     * @param  string|null  $until  결제 이벤트 생성시점 범위 조건의 끝: 값을 입력하지 않으면 현재 시점으로 설정됩니다.
     * @param  string|null  $cursor  커서: 결제 이벤트 리스트 중 어디서부터 읽어야 할지 가리키는 값입니다. 최초 요청일 경우 값을 입력하지 마시되, 두번째 요청 부터는 이전 요청 응답값의 cursor를 입력해주시면 됩니다.
     * @param  int|null  $size  페이지 크기: 미입력 시 기본값은 10 이며 최대 1000까지 허용
     * @param  string|null  $storeId  상점 아이디: Merchant 사용자만 사용가능하며, 지정되지 않은 경우 고객사 전체 결제 이벤트를 조회합니다.
     */
    public function getAllPaymentEventsByCursor(?string $from = null, ?string $until = null, ?string $cursor = null, ?int $size = null, ?string $storeId = null): Model\GetAllPaymentEventsByCursorResponse
    {
        return $this->callOperation('getAllPaymentEventsByCursor', 'GET', '/payment-events-by-cursor', ['storeId' => $storeId, 'from' => $from, 'until' => $until, 'cursor' => $cursor, 'size' => $size], Model\GetAllPaymentEventsByCursorResponse::class, true);
    }

    /**
     * 결제 이벤트 대용량 다건 조회(커서 기반) 기능입니다.
     * 기간 내 모든 결제 이벤트를 커서 기반으로 조회합니다. 결제 이벤트의 생성일시를 기준으로 주어진 기간 내 존재하는 모든 결제 이벤트가 조회됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $from  결제 이벤트 생성시점 범위 조건의 시작: 값을 입력하지 않으면 end의 90일 전으로 설정됩니다.
     * @param  string|null  $until  결제 이벤트 생성시점 범위 조건의 끝: 값을 입력하지 않으면 현재 시점으로 설정됩니다.
     * @param  string|null  $cursor  커서: 결제 이벤트 리스트 중 어디서부터 읽어야 할지 가리키는 값입니다. 최초 요청일 경우 값을 입력하지 마시되, 두번째 요청 부터는 이전 요청 응답값의 cursor를 입력해주시면 됩니다.
     * @param  int|null  $size  페이지 크기: 미입력 시 기본값은 10 이며 최대 1000까지 허용
     * @param  string|null  $storeId  상점 아이디: Merchant 사용자만 사용가능하며, 지정되지 않은 경우 고객사 전체 결제 이벤트를 조회합니다.
     */
    public function getAllPaymentEventsByCursorAsync(?string $from = null, ?string $until = null, ?string $cursor = null, ?int $size = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getAllPaymentEventsByCursor', 'GET', '/payment-events-by-cursor', ['storeId' => $storeId, 'from' => $from, 'until' => $until, 'cursor' => $cursor, 'size' => $size], Model\GetAllPaymentEventsByCursorResponse::class, true);
    }

    /**
     * 결제 대용량 다건 조회(커서 기반) 기능입니다.
     * 기간 내 모든 결제 건을 커서 기반으로 조회합니다. 결제 건의 생성일시를 기준으로 주어진 기간 내 존재하는 모든 결제 건이 조회됩니다.
     *
     * @param  string|null  $from  결제 건 생성시점 범위 조건의 시작: 값을 입력하지 않으면 end의 90일 전으로 설정됩니다.
     * @param  string|null  $until  결제 건 생성시점 범위 조건의 끝: 값을 입력하지 않으면 현재 시점으로 설정됩니다.
     * @param  string|null  $cursor  커서: 결제 건 리스트 중 어디서부터 읽어야 할지 가리키는 값입니다. 최초 요청일 경우 값을 입력하지 마시되, 두번째 요청 부터는 이전 요청 응답값의 cursor를 입력해주시면 됩니다.
     * @param  int|null  $size  페이지 크기: 미입력 시 기본값은 10 이며 최대 1000까지 허용
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function getAllPaymentsByCursor(?string $from = null, ?string $until = null, ?string $cursor = null, ?int $size = null, ?string $storeId = null): Model\GetAllPaymentsByCursorResponse
    {
        return $this->callOperation('getAllPaymentsByCursor', 'GET', '/payments-by-cursor', ['storeId' => $storeId, 'from' => $from, 'until' => $until, 'cursor' => $cursor, 'size' => $size], Model\GetAllPaymentsByCursorResponse::class, true);
    }

    /**
     * 결제 대용량 다건 조회(커서 기반) 기능입니다.
     * 기간 내 모든 결제 건을 커서 기반으로 조회합니다. 결제 건의 생성일시를 기준으로 주어진 기간 내 존재하는 모든 결제 건이 조회됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $from  결제 건 생성시점 범위 조건의 시작: 값을 입력하지 않으면 end의 90일 전으로 설정됩니다.
     * @param  string|null  $until  결제 건 생성시점 범위 조건의 끝: 값을 입력하지 않으면 현재 시점으로 설정됩니다.
     * @param  string|null  $cursor  커서: 결제 건 리스트 중 어디서부터 읽어야 할지 가리키는 값입니다. 최초 요청일 경우 값을 입력하지 마시되, 두번째 요청 부터는 이전 요청 응답값의 cursor를 입력해주시면 됩니다.
     * @param  int|null  $size  페이지 크기: 미입력 시 기본값은 10 이며 최대 1000까지 허용
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function getAllPaymentsByCursorAsync(?string $from = null, ?string $until = null, ?string $cursor = null, ?int $size = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getAllPaymentsByCursor', 'GET', '/payments-by-cursor', ['storeId' => $storeId, 'from' => $from, 'until' => $until, 'cursor' => $cursor, 'size' => $size], Model\GetAllPaymentsByCursorResponse::class, true);
    }

    /**
     * 결제 단건 조회 기능입니다.
     * 주어진 아이디에 대응되는 결제 건을 조회합니다.
     *
     * @param  string|null  $paymentId  조회할 결제 아이디
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function getPayment(?string $paymentId = null, ?string $storeId = null): Model\Payment
    {
        return $this->callOperation('getPayment', 'GET', '/payments/{paymentId}', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\Payment::class, false);
    }

    /**
     * 결제 단건 조회 기능입니다.
     * 주어진 아이디에 대응되는 결제 건을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  조회할 결제 아이디
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function getPaymentAsync(?string $paymentId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getPayment', 'GET', '/payments/{paymentId}', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\Payment::class, false);
    }

    /**
     * 결제 시도 내역 조회 기능입니다.
     * 주어진 아이디에 대응되는 결제 건의 결제 시도 내역을 조회합니다.
     *
     * @param  string|null  $paymentId  조회할 결제 아이디
     * @param  string|null  $storeId  상점 아이디
     */
    public function getPaymentTransactions(?string $paymentId = null, ?string $storeId = null): Model\GetPaymentTransactionsResponse
    {
        return $this->callOperation('getPaymentTransactions', 'GET', '/payments/{paymentId}/transactions', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\GetPaymentTransactionsResponse::class, false);
    }

    /**
     * 결제 시도 내역 조회 기능입니다.
     * 주어진 아이디에 대응되는 결제 건의 결제 시도 내역을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  조회할 결제 아이디
     * @param  string|null  $storeId  상점 아이디
     */
    public function getPaymentTransactionsAsync(?string $paymentId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getPaymentTransactions', 'GET', '/payments/{paymentId}/transactions', ['storeId' => $storeId, 'paymentId' => $paymentId], Model\GetPaymentTransactionsResponse::class, false);
    }

    /**
     * 에스크로 배송 정보 수정 기능입니다.
     * 에스크로 배송 정보를 수정합니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  array<string, mixed>|null  $sender  에스크로 발송자 정보
     * @param  array<string, mixed>|null  $receiver  에스크로 수취인 정보
     * @param  array<string, mixed>|null  $logistics  배송정보
     * @param  bool|null  $sendEmail  이메일 알림 전송 여부: 에스크로 구매 확정 시 이메일로 알림을 보낼지 여부입니다.
     * @param  array<string, mixed>|null  $products  상품 정보
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function modifyEscrowLogistics(?string $paymentId = null, ?array $sender = null, ?array $receiver = null, ?array $logistics = null, ?bool $sendEmail = null, ?array $products = null, ?string $storeId = null): Model\ModifyEscrowLogisticsResponse
    {
        return $this->callOperation('modifyEscrowLogistics', 'PATCH', '/payments/{paymentId}/escrow/logistics', ['storeId' => $storeId, 'paymentId' => $paymentId, 'sender' => $sender, 'receiver' => $receiver, 'logistics' => $logistics, 'sendEmail' => $sendEmail, 'products' => $products], Model\ModifyEscrowLogisticsResponse::class, true);
    }

    /**
     * 에스크로 배송 정보 수정 기능입니다.
     * 에스크로 배송 정보를 수정합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  array<string, mixed>|null  $sender  에스크로 발송자 정보
     * @param  array<string, mixed>|null  $receiver  에스크로 수취인 정보
     * @param  array<string, mixed>|null  $logistics  배송정보
     * @param  bool|null  $sendEmail  이메일 알림 전송 여부: 에스크로 구매 확정 시 이메일로 알림을 보낼지 여부입니다.
     * @param  array<string, mixed>|null  $products  상품 정보
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function modifyEscrowLogisticsAsync(?string $paymentId = null, ?array $sender = null, ?array $receiver = null, ?array $logistics = null, ?bool $sendEmail = null, ?array $products = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('modifyEscrowLogistics', 'PATCH', '/payments/{paymentId}/escrow/logistics', ['storeId' => $storeId, 'paymentId' => $paymentId, 'sender' => $sender, 'receiver' => $receiver, 'logistics' => $logistics, 'sendEmail' => $sendEmail, 'products' => $products], Model\ModifyEscrowLogisticsResponse::class, true);
    }

    /**
     * 수기 결제 기능입니다.
     * 카드 비인증 결제 또는 가상 계좌 발급을 API로 요청합니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $channelKey  채널 키 또는 채널 그룹 ID 필수
     * @param  string|null  $channelGroupId  채널 키 또는 채널 그룹 ID 필수
     * @param  array<string, mixed>|null  $method  수기 결제 수단 입력 정보: 하나의 필드만 입력합니다.
     * @param  string|null  $orderName  주문명
     * @param  bool|null  $isCulturalExpense  문화비 지출 여부: 기본값은 false 입니다.
     * @param  bool|null  $isEscrow  에스크로 결제 여부: 기본값은 false 입니다.
     * @param  array<string, mixed>|null  $customer  고객 정보 입력 정보
     * @param  string|null  $customData  사용자 지정 데이터
     * @param  array<string, mixed>|null  $amount  금액 세부 입력 정보
     * @param  string|null  $currency  통화
     * @param  string|null  $country  국가
     * @param  array<string, mixed>|null  $noticeUrls  결제 웹훅 주소입니다. 상점에 설정되어 있는 값보다 우선적으로 적용됩니다. 빈 배열은 무시됩니다.
     * @param  array<string, mixed>|null  $products  상품 정보: 입력된 값이 없을 경우에는 빈 배열로 해석됩니다.
     * @param  int|null  $productCount  상품 개수
     * @param  string|null  $productType  상품 유형
     * @param  array<string, mixed>|null  $shippingAddress  분리 형식 주소 입력 정보
     * @param  string|null  $promotionId  해당 결제에 적용할 프로모션 아이디
     * @param  array<string, mixed>|null  $bypass  PG사별 추가 파라미터 ("PG사별 연동 가이드" 참고)
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 결제가 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다. 가상계좌 입금 완료 등 외부 이벤트로 결제가 완료되는 경우 발생하는 웹훅은 스킵되지 않습니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function payInstantly(?string $paymentId = null, ?string $channelKey = null, ?string $channelGroupId = null, ?array $method = null, ?string $orderName = null, ?bool $isCulturalExpense = null, ?bool $isEscrow = null, ?array $customer = null, ?string $customData = null, ?array $amount = null, ?string $currency = null, ?string $country = null, ?array $noticeUrls = null, ?array $products = null, ?int $productCount = null, ?string $productType = null, ?array $shippingAddress = null, ?string $promotionId = null, ?array $bypass = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\PayInstantlyResponse
    {
        return $this->callOperation('payInstantly', 'POST', '/payments/{paymentId}/instant', ['storeId' => $storeId, 'paymentId' => $paymentId, 'channelKey' => $channelKey, 'channelGroupId' => $channelGroupId, 'method' => $method, 'orderName' => $orderName, 'isCulturalExpense' => $isCulturalExpense, 'isEscrow' => $isEscrow, 'customer' => $customer, 'customData' => $customData, 'amount' => $amount, 'currency' => $currency, 'country' => $country, 'noticeUrls' => $noticeUrls, 'products' => $products, 'productCount' => $productCount, 'productType' => $productType, 'shippingAddress' => $shippingAddress, 'promotionId' => $promotionId, 'bypass' => $bypass, 'skipWebhook' => $skipWebhook], Model\PayInstantlyResponse::class, true);
    }

    /**
     * 수기 결제 기능입니다.
     * 카드 비인증 결제 또는 가상 계좌 발급을 API로 요청합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $channelKey  채널 키 또는 채널 그룹 ID 필수
     * @param  string|null  $channelGroupId  채널 키 또는 채널 그룹 ID 필수
     * @param  array<string, mixed>|null  $method  수기 결제 수단 입력 정보: 하나의 필드만 입력합니다.
     * @param  string|null  $orderName  주문명
     * @param  bool|null  $isCulturalExpense  문화비 지출 여부: 기본값은 false 입니다.
     * @param  bool|null  $isEscrow  에스크로 결제 여부: 기본값은 false 입니다.
     * @param  array<string, mixed>|null  $customer  고객 정보 입력 정보
     * @param  string|null  $customData  사용자 지정 데이터
     * @param  array<string, mixed>|null  $amount  금액 세부 입력 정보
     * @param  string|null  $currency  통화
     * @param  string|null  $country  국가
     * @param  array<string, mixed>|null  $noticeUrls  결제 웹훅 주소입니다. 상점에 설정되어 있는 값보다 우선적으로 적용됩니다. 빈 배열은 무시됩니다.
     * @param  array<string, mixed>|null  $products  상품 정보: 입력된 값이 없을 경우에는 빈 배열로 해석됩니다.
     * @param  int|null  $productCount  상품 개수
     * @param  string|null  $productType  상품 유형
     * @param  array<string, mixed>|null  $shippingAddress  분리 형식 주소 입력 정보
     * @param  string|null  $promotionId  해당 결제에 적용할 프로모션 아이디
     * @param  array<string, mixed>|null  $bypass  PG사별 추가 파라미터 ("PG사별 연동 가이드" 참고)
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 결제가 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다. 가상계좌 입금 완료 등 외부 이벤트로 결제가 완료되는 경우 발생하는 웹훅은 스킵되지 않습니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function payInstantlyAsync(?string $paymentId = null, ?string $channelKey = null, ?string $channelGroupId = null, ?array $method = null, ?string $orderName = null, ?bool $isCulturalExpense = null, ?bool $isEscrow = null, ?array $customer = null, ?string $customData = null, ?array $amount = null, ?string $currency = null, ?string $country = null, ?array $noticeUrls = null, ?array $products = null, ?int $productCount = null, ?string $productType = null, ?array $shippingAddress = null, ?string $promotionId = null, ?array $bypass = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('payInstantly', 'POST', '/payments/{paymentId}/instant', ['storeId' => $storeId, 'paymentId' => $paymentId, 'channelKey' => $channelKey, 'channelGroupId' => $channelGroupId, 'method' => $method, 'orderName' => $orderName, 'isCulturalExpense' => $isCulturalExpense, 'isEscrow' => $isEscrow, 'customer' => $customer, 'customData' => $customData, 'amount' => $amount, 'currency' => $currency, 'country' => $country, 'noticeUrls' => $noticeUrls, 'products' => $products, 'productCount' => $productCount, 'productType' => $productType, 'shippingAddress' => $shippingAddress, 'promotionId' => $promotionId, 'bypass' => $bypass, 'skipWebhook' => $skipWebhook], Model\PayInstantlyResponse::class, true);
    }

    /**
     * 빌링키 결제 기능입니다.
     * 빌링키로 결제를 진행합니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $billingKey  빌링키 결제에 사용할 빌링키
     * @param  string|null  $channelKey  채널 키: 다수 채널에 대해 발급된 빌링키에 대해, 결제 채널을 특정하고 싶을 때 명시
     * @param  string|null  $orderName  주문명
     * @param  array<string, mixed>|null  $customer  고객 정보 입력 정보
     * @param  string|null  $customData  사용자 지정 데이터
     * @param  array<string, mixed>|null  $amount  금액 세부 입력 정보
     * @param  string|null  $currency  통화
     * @param  int|null  $installmentMonth  할부 개월 수
     * @param  bool|null  $useFreeInterestFromMerchant  무이자 할부 이자를 고객사가 부담할지 여부
     * @param  bool|null  $useCardPoint  카드 포인트 사용 여부
     * @param  array<string, mixed>|null  $cashReceipt  현금영수증 입력 정보: 나이스페이먼츠를 통해 네이버페이 포인트 빌링결제 시, 현금영수증 발급을 위해 입력 가능 (신청 필요)
     * @param  string|null  $country  국가
     * @param  array<string, mixed>|null  $noticeUrls  결제 승인/실패 시 요청을 받을 웹훅 주소입니다. 상점에 설정되어 있는 값보다 우선적으로 적용됩니다. 빈 배열은 무시됩니다.
     * @param  array<string, mixed>|null  $products  상품 정보: 입력된 값이 없을 경우에는 빈 배열로 해석됩니다.
     * @param  int|null  $productCount  상품 개수
     * @param  string|null  $productType  상품 유형
     * @param  array<string, mixed>|null  $shippingAddress  분리 형식 주소 입력 정보
     * @param  string|null  $promotionId  해당 결제에 적용할 프로모션 아이디
     * @param  string|null  $locale  결제 언어: 엑심베이의 경우 필수 입력입니다.
     * @param  array<string, mixed>|null  $bypass  PG사별 추가 파라미터 ("PG사별 연동 가이드" 참고)
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 결제가 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다. 가상계좌 입금 완료 등 외부 이벤트로 결제가 완료되는 경우 발생하는 웹훅은 스킵되지 않습니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function payWithBillingKey(?string $paymentId = null, ?string $billingKey = null, ?string $channelKey = null, ?string $orderName = null, ?array $customer = null, ?string $customData = null, ?array $amount = null, ?string $currency = null, ?int $installmentMonth = null, ?bool $useFreeInterestFromMerchant = null, ?bool $useCardPoint = null, ?array $cashReceipt = null, ?string $country = null, ?array $noticeUrls = null, ?array $products = null, ?int $productCount = null, ?string $productType = null, ?array $shippingAddress = null, ?string $promotionId = null, ?string $locale = null, ?array $bypass = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\PayWithBillingKeyResponse
    {
        return $this->callOperation('payWithBillingKey', 'POST', '/payments/{paymentId}/billing-key', ['storeId' => $storeId, 'paymentId' => $paymentId, 'billingKey' => $billingKey, 'channelKey' => $channelKey, 'orderName' => $orderName, 'customer' => $customer, 'customData' => $customData, 'amount' => $amount, 'currency' => $currency, 'installmentMonth' => $installmentMonth, 'useFreeInterestFromMerchant' => $useFreeInterestFromMerchant, 'useCardPoint' => $useCardPoint, 'cashReceipt' => $cashReceipt, 'country' => $country, 'noticeUrls' => $noticeUrls, 'products' => $products, 'productCount' => $productCount, 'productType' => $productType, 'shippingAddress' => $shippingAddress, 'promotionId' => $promotionId, 'locale' => $locale, 'bypass' => $bypass, 'skipWebhook' => $skipWebhook], Model\PayWithBillingKeyResponse::class, true);
    }

    /**
     * 빌링키 결제 기능입니다.
     * 빌링키로 결제를 진행합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $billingKey  빌링키 결제에 사용할 빌링키
     * @param  string|null  $channelKey  채널 키: 다수 채널에 대해 발급된 빌링키에 대해, 결제 채널을 특정하고 싶을 때 명시
     * @param  string|null  $orderName  주문명
     * @param  array<string, mixed>|null  $customer  고객 정보 입력 정보
     * @param  string|null  $customData  사용자 지정 데이터
     * @param  array<string, mixed>|null  $amount  금액 세부 입력 정보
     * @param  string|null  $currency  통화
     * @param  int|null  $installmentMonth  할부 개월 수
     * @param  bool|null  $useFreeInterestFromMerchant  무이자 할부 이자를 고객사가 부담할지 여부
     * @param  bool|null  $useCardPoint  카드 포인트 사용 여부
     * @param  array<string, mixed>|null  $cashReceipt  현금영수증 입력 정보: 나이스페이먼츠를 통해 네이버페이 포인트 빌링결제 시, 현금영수증 발급을 위해 입력 가능 (신청 필요)
     * @param  string|null  $country  국가
     * @param  array<string, mixed>|null  $noticeUrls  결제 승인/실패 시 요청을 받을 웹훅 주소입니다. 상점에 설정되어 있는 값보다 우선적으로 적용됩니다. 빈 배열은 무시됩니다.
     * @param  array<string, mixed>|null  $products  상품 정보: 입력된 값이 없을 경우에는 빈 배열로 해석됩니다.
     * @param  int|null  $productCount  상품 개수
     * @param  string|null  $productType  상품 유형
     * @param  array<string, mixed>|null  $shippingAddress  분리 형식 주소 입력 정보
     * @param  string|null  $promotionId  해당 결제에 적용할 프로모션 아이디
     * @param  string|null  $locale  결제 언어: 엑심베이의 경우 필수 입력입니다.
     * @param  array<string, mixed>|null  $bypass  PG사별 추가 파라미터 ("PG사별 연동 가이드" 참고)
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 결제가 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다. 가상계좌 입금 완료 등 외부 이벤트로 결제가 완료되는 경우 발생하는 웹훅은 스킵되지 않습니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function payWithBillingKeyAsync(?string $paymentId = null, ?string $billingKey = null, ?string $channelKey = null, ?string $orderName = null, ?array $customer = null, ?string $customData = null, ?array $amount = null, ?string $currency = null, ?int $installmentMonth = null, ?bool $useFreeInterestFromMerchant = null, ?bool $useCardPoint = null, ?array $cashReceipt = null, ?string $country = null, ?array $noticeUrls = null, ?array $products = null, ?int $productCount = null, ?string $productType = null, ?array $shippingAddress = null, ?string $promotionId = null, ?string $locale = null, ?array $bypass = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('payWithBillingKey', 'POST', '/payments/{paymentId}/billing-key', ['storeId' => $storeId, 'paymentId' => $paymentId, 'billingKey' => $billingKey, 'channelKey' => $channelKey, 'orderName' => $orderName, 'customer' => $customer, 'customData' => $customData, 'amount' => $amount, 'currency' => $currency, 'installmentMonth' => $installmentMonth, 'useFreeInterestFromMerchant' => $useFreeInterestFromMerchant, 'useCardPoint' => $useCardPoint, 'cashReceipt' => $cashReceipt, 'country' => $country, 'noticeUrls' => $noticeUrls, 'products' => $products, 'productCount' => $productCount, 'productType' => $productType, 'shippingAddress' => $shippingAddress, 'promotionId' => $promotionId, 'locale' => $locale, 'bypass' => $bypass, 'skipWebhook' => $skipWebhook], Model\PayWithBillingKeyResponse::class, true);
    }

    /**
     * 결제 정보 사전 등록 기능입니다.
     * 결제 정보를 사전 등록합니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  int|null  $totalAmount  결제 총 금액
     * @param  int|null  $taxFreeAmount  결제 면세 금액
     * @param  string|null  $currency  통화
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function preRegisterPayment(?string $paymentId = null, ?int $totalAmount = null, ?int $taxFreeAmount = null, ?string $currency = null, ?string $storeId = null): Model\PreRegisterPaymentResponse
    {
        return $this->callOperation('preRegisterPayment', 'POST', '/payments/{paymentId}/pre-register', ['storeId' => $storeId, 'paymentId' => $paymentId, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'currency' => $currency], Model\PreRegisterPaymentResponse::class, true);
    }

    /**
     * 결제 정보 사전 등록 기능입니다.
     * 결제 정보를 사전 등록합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  int|null  $totalAmount  결제 총 금액
     * @param  int|null  $taxFreeAmount  결제 면세 금액
     * @param  string|null  $currency  통화
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function preRegisterPaymentAsync(?string $paymentId = null, ?int $totalAmount = null, ?int $taxFreeAmount = null, ?string $currency = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('preRegisterPayment', 'POST', '/payments/{paymentId}/pre-register', ['storeId' => $storeId, 'paymentId' => $paymentId, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'currency' => $currency], Model\PreRegisterPaymentResponse::class, true);
    }

    /**
     * 영수증 내 하위 상점 거래 등록 기능입니다.
     * 결제 내역 매출전표에 하위 상점의 거래를 등록합니다.
     * 지원되는 PG사:
     * KG이니시스(이용 전 콘솔 -> 결제연동 탭에서 INIApi Key 등록 필요)
     *
     * @param  string|null  $paymentId  등록할 하위 상점 결제 건 아이디
     * @param  array<string, mixed>|null  $items  하위 상점 거래 목록
     * @param  string|null  $storeId  상점 아이디
     */
    public function registerStoreReceipt(?string $paymentId = null, ?array $items = null, ?string $storeId = null): Model\RegisterStoreReceiptResponse
    {
        return $this->callOperation('registerStoreReceipt', 'POST', '/payments/{paymentId}/register-store-receipt', ['storeId' => $storeId, 'paymentId' => $paymentId, 'items' => $items], Model\RegisterStoreReceiptResponse::class, true);
    }

    /**
     * 영수증 내 하위 상점 거래 등록 기능입니다.
     * 결제 내역 매출전표에 하위 상점의 거래를 등록합니다.
     * 지원되는 PG사:
     * KG이니시스(이용 전 콘솔 -> 결제연동 탭에서 INIApi Key 등록 필요)
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  등록할 하위 상점 결제 건 아이디
     * @param  array<string, mixed>|null  $items  하위 상점 거래 목록
     * @param  string|null  $storeId  상점 아이디
     */
    public function registerStoreReceiptAsync(?string $paymentId = null, ?array $items = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('registerStoreReceipt', 'POST', '/payments/{paymentId}/register-store-receipt', ['storeId' => $storeId, 'paymentId' => $paymentId, 'items' => $items], Model\RegisterStoreReceiptResponse::class, true);
    }

    /**
     * 웹훅 재발송 기능입니다.
     * 웹훅을 재발송합니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $webhookId  입력하지 않으면 결제 건의 가장 최근 웹훅 아이디가 기본 적용됩니다
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function resendWebhook(?string $paymentId = null, ?string $webhookId = null, ?string $storeId = null): Model\ResendWebhookResponse
    {
        return $this->callOperation('resendWebhook', 'POST', '/payments/{paymentId}/resend-webhook', ['storeId' => $storeId, 'paymentId' => $paymentId, 'webhookId' => $webhookId], Model\ResendWebhookResponse::class, true);
    }

    /**
     * 웹훅 재발송 기능입니다.
     * 웹훅을 재발송합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $webhookId  입력하지 않으면 결제 건의 가장 최근 웹훅 아이디가 기본 적용됩니다
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function resendWebhookAsync(?string $paymentId = null, ?string $webhookId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('resendWebhook', 'POST', '/payments/{paymentId}/resend-webhook', ['storeId' => $storeId, 'paymentId' => $paymentId, 'webhookId' => $webhookId], Model\ResendWebhookResponse::class, true);
    }

    /**
     * 결제 취소 요청 취소 기능입니다.
     * 비동기적으로 수행되는 결제 취소 요청을 취소합니다.
     * Triple-A에서만 사용됩니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $cancellationId  취소 요청 아이디
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function stopPaymentCancellation(?string $paymentId = null, ?string $cancellationId = null, ?string $storeId = null): Model\StopPaymentCancellationResponse
    {
        return $this->callOperation('stopPaymentCancellation', 'POST', '/payments/{paymentId}/cancellations/{cancellationId}/stop', ['storeId' => $storeId, 'paymentId' => $paymentId, 'cancellationId' => $cancellationId], Model\StopPaymentCancellationResponse::class, true);
    }

    /**
     * 결제 취소 요청 취소 기능입니다.
     * 비동기적으로 수행되는 결제 취소 요청을 취소합니다.
     * Triple-A에서만 사용됩니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $paymentId  결제 건 아이디
     * @param  string|null  $cancellationId  취소 요청 아이디
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function stopPaymentCancellationAsync(?string $paymentId = null, ?string $cancellationId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('stopPaymentCancellation', 'POST', '/payments/{paymentId}/cancellations/{cancellationId}/stop', ['storeId' => $storeId, 'paymentId' => $paymentId, 'cancellationId' => $cancellationId], Model\StopPaymentCancellationResponse::class, true);
    }
}
