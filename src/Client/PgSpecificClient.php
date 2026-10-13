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
해당 API 사용이 필요한 경우 포트원 기술지원팀으로 문의 주시길 바랍니다.
     */
    public function getKakaopayPaymentOrder(?string $pgTxId = null, ?string $channelKey = null): Model\GetKakaopayPaymentOrderResponse
    {
        return $this->callOperation('getKakaopayPaymentOrder', 'GET', '/kakaopay/payment/order', ['pgTxId' => $pgTxId, 'channelKey' => $channelKey], Model\GetKakaopayPaymentOrderResponse::class, false);
    }

    /**
     * 카카오페이 주문 조회 API 기능입니다.
     * 주어진 아이디에 대응되는 카카오페이 주문 건을 조회합니다.
해당 API 사용이 필요한 경우 포트원 기술지원팀으로 문의 주시길 바랍니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getKakaopayPaymentOrderAsync(?string $pgTxId = null, ?string $channelKey = null): Future
    {
        return $this->callOperationAsync('getKakaopayPaymentOrder', 'GET', '/kakaopay/payment/order', ['pgTxId' => $pgTxId, 'channelKey' => $channelKey], Model\GetKakaopayPaymentOrderResponse::class, false);
    }

    /**
     * 페이먼트월 배송 정보 등록 기능입니다.
     * 배송 정보를 페이먼트월에 등록합니다.
등록된 배송 정보는 차지백 발생 시 고객사의 상품 배송 완료 증빙 자료로 활용되므로, 반드시 연동해야 합니다.
     */
    public function confirmPaymentwallDelivery(?string $transactionId = null, ?string $deliveryType = null, ?string $deliveryStatus = null, ?string $estimatedDeliveryDatetime = null, ?string $estimatedUpdateDatetime = null, ?string $reason = null, ?bool $refundable = null, ?string $details = null, ?string $shippingAddressEmail = null, ?string $carrierTrackingId = null, ?string $carrierType = null, ?string $shippingAddressCountry = null, ?string $shippingAddressCity = null, ?string $shippingAddressZip = null, ?string $shippingAddressState = null, ?string $shippingAddressStreet = null, ?string $shippingAddressPhone = null, ?string $shippingAddressFirstname = null, ?string $shippingAddressLastname = null, ?array $attachments = null): Model\ConfirmPaymentwallDeliveryResponse
    {
        return $this->callOperation('confirmPaymentwallDelivery', 'POST', '/paymentwall/delivery/confirm', ['transactionId' => $transactionId, 'deliveryType' => $deliveryType, 'deliveryStatus' => $deliveryStatus, 'estimatedDeliveryDatetime' => $estimatedDeliveryDatetime, 'estimatedUpdateDatetime' => $estimatedUpdateDatetime, 'reason' => $reason, 'refundable' => $refundable, 'details' => $details, 'shippingAddressEmail' => $shippingAddressEmail, 'carrierTrackingId' => $carrierTrackingId, 'carrierType' => $carrierType, 'shippingAddressCountry' => $shippingAddressCountry, 'shippingAddressCity' => $shippingAddressCity, 'shippingAddressZip' => $shippingAddressZip, 'shippingAddressState' => $shippingAddressState, 'shippingAddressStreet' => $shippingAddressStreet, 'shippingAddressPhone' => $shippingAddressPhone, 'shippingAddressFirstname' => $shippingAddressFirstname, 'shippingAddressLastname' => $shippingAddressLastname, 'attachments' => $attachments], Model\ConfirmPaymentwallDeliveryResponse::class, true);
    }

    /**
     * 페이먼트월 배송 정보 등록 기능입니다.
     * 배송 정보를 페이먼트월에 등록합니다.
등록된 배송 정보는 차지백 발생 시 고객사의 상품 배송 완료 증빙 자료로 활용되므로, 반드시 연동해야 합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function confirmPaymentwallDeliveryAsync(?string $transactionId = null, ?string $deliveryType = null, ?string $deliveryStatus = null, ?string $estimatedDeliveryDatetime = null, ?string $estimatedUpdateDatetime = null, ?string $reason = null, ?bool $refundable = null, ?string $details = null, ?string $shippingAddressEmail = null, ?string $carrierTrackingId = null, ?string $carrierType = null, ?string $shippingAddressCountry = null, ?string $shippingAddressCity = null, ?string $shippingAddressZip = null, ?string $shippingAddressState = null, ?string $shippingAddressStreet = null, ?string $shippingAddressPhone = null, ?string $shippingAddressFirstname = null, ?string $shippingAddressLastname = null, ?array $attachments = null): Future
    {
        return $this->callOperationAsync('confirmPaymentwallDelivery', 'POST', '/paymentwall/delivery/confirm', ['transactionId' => $transactionId, 'deliveryType' => $deliveryType, 'deliveryStatus' => $deliveryStatus, 'estimatedDeliveryDatetime' => $estimatedDeliveryDatetime, 'estimatedUpdateDatetime' => $estimatedUpdateDatetime, 'reason' => $reason, 'refundable' => $refundable, 'details' => $details, 'shippingAddressEmail' => $shippingAddressEmail, 'carrierTrackingId' => $carrierTrackingId, 'carrierType' => $carrierType, 'shippingAddressCountry' => $shippingAddressCountry, 'shippingAddressCity' => $shippingAddressCity, 'shippingAddressZip' => $shippingAddressZip, 'shippingAddressState' => $shippingAddressState, 'shippingAddressStreet' => $shippingAddressStreet, 'shippingAddressPhone' => $shippingAddressPhone, 'shippingAddressFirstname' => $shippingAddressFirstname, 'shippingAddressLastname' => $shippingAddressLastname, 'attachments' => $attachments], Model\ConfirmPaymentwallDeliveryResponse::class, true);
    }
}
