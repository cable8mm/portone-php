<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * PG사별 API 작업을 제공합니다.
 */
final class PgSpecificClient extends AbstractClient
{
    /**
     * 카카오페이 주문 조회 API 기능입니다.
     * 주어진 아이디에 대응되는 카카오페이 주문 건을 조회합니다.
     * 해당 API 사용이 필요한 경우 포트원 기술지원팀으로 문의 주시길 바랍니다.
     *
     * @param  string|null  $pgTxId  카카오페이 주문 번호 (tid)
     * @param  string|null  $channelKey  채널 키
     */
    public function getKakaopayPaymentOrder(?string $pgTxId = null, ?string $channelKey = null): Model\GetKakaopayPaymentOrderResponse
    {
        return $this->callOperation('getKakaopayPaymentOrder', 'GET', '/kakaopay/payment/order', ['pgTxId' => $pgTxId, 'channelKey' => $channelKey], Model\GetKakaopayPaymentOrderResponse::class, false);
    }

    /**
     * 카카오페이 주문 조회 API 기능입니다.
     * 주어진 아이디에 대응되는 카카오페이 주문 건을 조회합니다.
     * 해당 API 사용이 필요한 경우 포트원 기술지원팀으로 문의 주시길 바랍니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $pgTxId  카카오페이 주문 번호 (tid)
     * @param  string|null  $channelKey  채널 키
     */
    public function getKakaopayPaymentOrderAsync(?string $pgTxId = null, ?string $channelKey = null): Future
    {
        return $this->callOperationAsync('getKakaopayPaymentOrder', 'GET', '/kakaopay/payment/order', ['pgTxId' => $pgTxId, 'channelKey' => $channelKey], Model\GetKakaopayPaymentOrderResponse::class, false);
    }

    /**
     * 페이먼트월 배송 정보 등록 기능입니다.
     * 배송 정보를 페이먼트월에 등록합니다.
     * 등록된 배송 정보는 차지백 발생 시 고객사의 상품 배송 완료 증빙 자료로 활용되므로, 반드시 연동해야 합니다.
     *
     * @param  string|null  $transactionId  결제 건 포트원 채번 아이디
     * @param  string|null  $deliveryType  페이먼트월 배송 유형
     * @param  string|null  $deliveryStatus  페이먼트월 배송 상태
     * @param  string|null  $estimatedDeliveryDatetime  배송 완료 예상 일시: 배송 유형이 DIGITAL인 경우 현재 시각을 입력해도 무방합니다.
     * @param  string|null  $estimatedUpdateDatetime  배송 상태 업데이트 예정 일시: 배송 유형이 DIGITAL인 경우 현재 시각을 입력해도 무방합니다.
     * @param  string|null  $reason  상태 변경 사유
     * @param  bool|null  $refundable  환불 가능 여부
     * @param  string|null  $details  상세 설명
     * @param  string|null  $shippingAddressEmail  고객 이메일 주소
     * @param  string|null  $carrierTrackingId  운송장 번호: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $carrierType  운송사 이름: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressCountry  국가: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressCity  수신자 도시: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressZip  수신자 우편번호: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressState  수신자 주: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressStreet  수신자 도로명 주소: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressPhone  수신자 전화번호: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressFirstname  수신자 이름: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressLastname  수신자 성: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  array<string, mixed>|null  $attachments  배송 증빙 첨부 파일 URL 목록: 배송 증빙 자료의 URL(이미지 등)을 입력합니다. 증빙 자료를 제공하기 어려운 경우 생략할 수 있습니다.
     */
    public function confirmPaymentwallDelivery(?string $transactionId = null, ?string $deliveryType = null, ?string $deliveryStatus = null, ?string $estimatedDeliveryDatetime = null, ?string $estimatedUpdateDatetime = null, ?string $reason = null, ?bool $refundable = null, ?string $details = null, ?string $shippingAddressEmail = null, ?string $carrierTrackingId = null, ?string $carrierType = null, ?string $shippingAddressCountry = null, ?string $shippingAddressCity = null, ?string $shippingAddressZip = null, ?string $shippingAddressState = null, ?string $shippingAddressStreet = null, ?string $shippingAddressPhone = null, ?string $shippingAddressFirstname = null, ?string $shippingAddressLastname = null, ?array $attachments = null): Model\ConfirmPaymentwallDeliveryResponse
    {
        return $this->callOperation('confirmPaymentwallDelivery', 'POST', '/paymentwall/delivery/confirm', ['transactionId' => $transactionId, 'deliveryType' => $deliveryType, 'deliveryStatus' => $deliveryStatus, 'estimatedDeliveryDatetime' => $estimatedDeliveryDatetime, 'estimatedUpdateDatetime' => $estimatedUpdateDatetime, 'reason' => $reason, 'refundable' => $refundable, 'details' => $details, 'shippingAddressEmail' => $shippingAddressEmail, 'carrierTrackingId' => $carrierTrackingId, 'carrierType' => $carrierType, 'shippingAddressCountry' => $shippingAddressCountry, 'shippingAddressCity' => $shippingAddressCity, 'shippingAddressZip' => $shippingAddressZip, 'shippingAddressState' => $shippingAddressState, 'shippingAddressStreet' => $shippingAddressStreet, 'shippingAddressPhone' => $shippingAddressPhone, 'shippingAddressFirstname' => $shippingAddressFirstname, 'shippingAddressLastname' => $shippingAddressLastname, 'attachments' => $attachments], Model\ConfirmPaymentwallDeliveryResponse::class, true);
    }

    /**
     * 페이먼트월 배송 정보 등록 기능입니다.
     * 배송 정보를 페이먼트월에 등록합니다.
     * 등록된 배송 정보는 차지백 발생 시 고객사의 상품 배송 완료 증빙 자료로 활용되므로, 반드시 연동해야 합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $transactionId  결제 건 포트원 채번 아이디
     * @param  string|null  $deliveryType  페이먼트월 배송 유형
     * @param  string|null  $deliveryStatus  페이먼트월 배송 상태
     * @param  string|null  $estimatedDeliveryDatetime  배송 완료 예상 일시: 배송 유형이 DIGITAL인 경우 현재 시각을 입력해도 무방합니다.
     * @param  string|null  $estimatedUpdateDatetime  배송 상태 업데이트 예정 일시: 배송 유형이 DIGITAL인 경우 현재 시각을 입력해도 무방합니다.
     * @param  string|null  $reason  상태 변경 사유
     * @param  bool|null  $refundable  환불 가능 여부
     * @param  string|null  $details  상세 설명
     * @param  string|null  $shippingAddressEmail  고객 이메일 주소
     * @param  string|null  $carrierTrackingId  운송장 번호: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $carrierType  운송사 이름: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressCountry  국가: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressCity  수신자 도시: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressZip  수신자 우편번호: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressState  수신자 주: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressStreet  수신자 도로명 주소: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressPhone  수신자 전화번호: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressFirstname  수신자 이름: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  string|null  $shippingAddressLastname  수신자 성: 배송 유형이 PHYSICAL인 경우 필수입니다.
     * @param  array<string, mixed>|null  $attachments  배송 증빙 첨부 파일 URL 목록: 배송 증빙 자료의 URL(이미지 등)을 입력합니다. 증빙 자료를 제공하기 어려운 경우 생략할 수 있습니다.
     */
    public function confirmPaymentwallDeliveryAsync(?string $transactionId = null, ?string $deliveryType = null, ?string $deliveryStatus = null, ?string $estimatedDeliveryDatetime = null, ?string $estimatedUpdateDatetime = null, ?string $reason = null, ?bool $refundable = null, ?string $details = null, ?string $shippingAddressEmail = null, ?string $carrierTrackingId = null, ?string $carrierType = null, ?string $shippingAddressCountry = null, ?string $shippingAddressCity = null, ?string $shippingAddressZip = null, ?string $shippingAddressState = null, ?string $shippingAddressStreet = null, ?string $shippingAddressPhone = null, ?string $shippingAddressFirstname = null, ?string $shippingAddressLastname = null, ?array $attachments = null): Future
    {
        return $this->callOperationAsync('confirmPaymentwallDelivery', 'POST', '/paymentwall/delivery/confirm', ['transactionId' => $transactionId, 'deliveryType' => $deliveryType, 'deliveryStatus' => $deliveryStatus, 'estimatedDeliveryDatetime' => $estimatedDeliveryDatetime, 'estimatedUpdateDatetime' => $estimatedUpdateDatetime, 'reason' => $reason, 'refundable' => $refundable, 'details' => $details, 'shippingAddressEmail' => $shippingAddressEmail, 'carrierTrackingId' => $carrierTrackingId, 'carrierType' => $carrierType, 'shippingAddressCountry' => $shippingAddressCountry, 'shippingAddressCity' => $shippingAddressCity, 'shippingAddressZip' => $shippingAddressZip, 'shippingAddressState' => $shippingAddressState, 'shippingAddressStreet' => $shippingAddressStreet, 'shippingAddressPhone' => $shippingAddressPhone, 'shippingAddressFirstname' => $shippingAddressFirstname, 'shippingAddressLastname' => $shippingAddressLastname, 'attachments' => $attachments], Model\ConfirmPaymentwallDeliveryResponse::class, true);
    }
}
