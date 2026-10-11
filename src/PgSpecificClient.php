<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class PgSpecificClient extends AbstractClient
{
    public function getKakaopayPaymentOrder(mixed $pgTxId = null, mixed $channelKey = null): Response\GetKakaopayPaymentOrderResponse
    {
        return $this->callOperation('getKakaopayPaymentOrder', 'GET', '/kakaopay/payment/order', ['pgTxId' => $pgTxId, 'channelKey' => $channelKey], Response\GetKakaopayPaymentOrderResponse::class, false);
    }

    public function getKakaopayPaymentOrderAsync(mixed $pgTxId = null, mixed $channelKey = null): Future
    {
        return $this->callOperationAsync('getKakaopayPaymentOrder', 'GET', '/kakaopay/payment/order', ['pgTxId' => $pgTxId, 'channelKey' => $channelKey], Response\GetKakaopayPaymentOrderResponse::class, false);
    }

    public function confirmPaymentwallDelivery(mixed $transactionId = null, mixed $deliveryType = null, mixed $deliveryStatus = null, mixed $estimatedDeliveryDatetime = null, mixed $estimatedUpdateDatetime = null, mixed $reason = null, mixed $refundable = null, mixed $details = null, mixed $shippingAddressEmail = null, mixed $carrierTrackingId = null, mixed $carrierType = null, mixed $shippingAddressCountry = null, mixed $shippingAddressCity = null, mixed $shippingAddressZip = null, mixed $shippingAddressState = null, mixed $shippingAddressStreet = null, mixed $shippingAddressPhone = null, mixed $shippingAddressFirstname = null, mixed $shippingAddressLastname = null, mixed $attachments = null): Response\ConfirmPaymentwallDeliveryResponse
    {
        return $this->callOperation('confirmPaymentwallDelivery', 'POST', '/paymentwall/delivery/confirm', ['transactionId' => $transactionId, 'deliveryType' => $deliveryType, 'deliveryStatus' => $deliveryStatus, 'estimatedDeliveryDatetime' => $estimatedDeliveryDatetime, 'estimatedUpdateDatetime' => $estimatedUpdateDatetime, 'reason' => $reason, 'refundable' => $refundable, 'details' => $details, 'shippingAddressEmail' => $shippingAddressEmail, 'carrierTrackingId' => $carrierTrackingId, 'carrierType' => $carrierType, 'shippingAddressCountry' => $shippingAddressCountry, 'shippingAddressCity' => $shippingAddressCity, 'shippingAddressZip' => $shippingAddressZip, 'shippingAddressState' => $shippingAddressState, 'shippingAddressStreet' => $shippingAddressStreet, 'shippingAddressPhone' => $shippingAddressPhone, 'shippingAddressFirstname' => $shippingAddressFirstname, 'shippingAddressLastname' => $shippingAddressLastname, 'attachments' => $attachments], Response\ConfirmPaymentwallDeliveryResponse::class, true);
    }

    public function confirmPaymentwallDeliveryAsync(mixed $transactionId = null, mixed $deliveryType = null, mixed $deliveryStatus = null, mixed $estimatedDeliveryDatetime = null, mixed $estimatedUpdateDatetime = null, mixed $reason = null, mixed $refundable = null, mixed $details = null, mixed $shippingAddressEmail = null, mixed $carrierTrackingId = null, mixed $carrierType = null, mixed $shippingAddressCountry = null, mixed $shippingAddressCity = null, mixed $shippingAddressZip = null, mixed $shippingAddressState = null, mixed $shippingAddressStreet = null, mixed $shippingAddressPhone = null, mixed $shippingAddressFirstname = null, mixed $shippingAddressLastname = null, mixed $attachments = null): Future
    {
        return $this->callOperationAsync('confirmPaymentwallDelivery', 'POST', '/paymentwall/delivery/confirm', ['transactionId' => $transactionId, 'deliveryType' => $deliveryType, 'deliveryStatus' => $deliveryStatus, 'estimatedDeliveryDatetime' => $estimatedDeliveryDatetime, 'estimatedUpdateDatetime' => $estimatedUpdateDatetime, 'reason' => $reason, 'refundable' => $refundable, 'details' => $details, 'shippingAddressEmail' => $shippingAddressEmail, 'carrierTrackingId' => $carrierTrackingId, 'carrierType' => $carrierType, 'shippingAddressCountry' => $shippingAddressCountry, 'shippingAddressCity' => $shippingAddressCity, 'shippingAddressZip' => $shippingAddressZip, 'shippingAddressState' => $shippingAddressState, 'shippingAddressStreet' => $shippingAddressStreet, 'shippingAddressPhone' => $shippingAddressPhone, 'shippingAddressFirstname' => $shippingAddressFirstname, 'shippingAddressLastname' => $shippingAddressLastname, 'attachments' => $attachments], Response\ConfirmPaymentwallDeliveryResponse::class, true);
    }
}
