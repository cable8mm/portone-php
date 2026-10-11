<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class PgSpecificClient extends AbstractClient
{
    public function getKakaopayPaymentOrder(?string $pgTxId = null, ?string $channelKey = null): Response\GetKakaopayPaymentOrderResponse
    {
        return $this->callOperation('getKakaopayPaymentOrder', 'GET', '/kakaopay/payment/order', ['pgTxId' => $pgTxId, 'channelKey' => $channelKey], Response\GetKakaopayPaymentOrderResponse::class, false);
    }

    public function getKakaopayPaymentOrderAsync(?string $pgTxId = null, ?string $channelKey = null): Future
    {
        return $this->callOperationAsync('getKakaopayPaymentOrder', 'GET', '/kakaopay/payment/order', ['pgTxId' => $pgTxId, 'channelKey' => $channelKey], Response\GetKakaopayPaymentOrderResponse::class, false);
    }

    public function confirmPaymentwallDelivery(?string $transactionId = null, ?string $deliveryType = null, ?string $deliveryStatus = null, ?string $estimatedDeliveryDatetime = null, ?string $estimatedUpdateDatetime = null, ?string $reason = null, ?bool $refundable = null, ?string $details = null, ?string $shippingAddressEmail = null, ?string $carrierTrackingId = null, ?string $carrierType = null, ?string $shippingAddressCountry = null, ?string $shippingAddressCity = null, ?string $shippingAddressZip = null, ?string $shippingAddressState = null, ?string $shippingAddressStreet = null, ?string $shippingAddressPhone = null, ?string $shippingAddressFirstname = null, ?string $shippingAddressLastname = null, ?array $attachments = null): Response\ConfirmPaymentwallDeliveryResponse
    {
        return $this->callOperation('confirmPaymentwallDelivery', 'POST', '/paymentwall/delivery/confirm', ['transactionId' => $transactionId, 'deliveryType' => $deliveryType, 'deliveryStatus' => $deliveryStatus, 'estimatedDeliveryDatetime' => $estimatedDeliveryDatetime, 'estimatedUpdateDatetime' => $estimatedUpdateDatetime, 'reason' => $reason, 'refundable' => $refundable, 'details' => $details, 'shippingAddressEmail' => $shippingAddressEmail, 'carrierTrackingId' => $carrierTrackingId, 'carrierType' => $carrierType, 'shippingAddressCountry' => $shippingAddressCountry, 'shippingAddressCity' => $shippingAddressCity, 'shippingAddressZip' => $shippingAddressZip, 'shippingAddressState' => $shippingAddressState, 'shippingAddressStreet' => $shippingAddressStreet, 'shippingAddressPhone' => $shippingAddressPhone, 'shippingAddressFirstname' => $shippingAddressFirstname, 'shippingAddressLastname' => $shippingAddressLastname, 'attachments' => $attachments], Response\ConfirmPaymentwallDeliveryResponse::class, true);
    }

    public function confirmPaymentwallDeliveryAsync(?string $transactionId = null, ?string $deliveryType = null, ?string $deliveryStatus = null, ?string $estimatedDeliveryDatetime = null, ?string $estimatedUpdateDatetime = null, ?string $reason = null, ?bool $refundable = null, ?string $details = null, ?string $shippingAddressEmail = null, ?string $carrierTrackingId = null, ?string $carrierType = null, ?string $shippingAddressCountry = null, ?string $shippingAddressCity = null, ?string $shippingAddressZip = null, ?string $shippingAddressState = null, ?string $shippingAddressStreet = null, ?string $shippingAddressPhone = null, ?string $shippingAddressFirstname = null, ?string $shippingAddressLastname = null, ?array $attachments = null): Future
    {
        return $this->callOperationAsync('confirmPaymentwallDelivery', 'POST', '/paymentwall/delivery/confirm', ['transactionId' => $transactionId, 'deliveryType' => $deliveryType, 'deliveryStatus' => $deliveryStatus, 'estimatedDeliveryDatetime' => $estimatedDeliveryDatetime, 'estimatedUpdateDatetime' => $estimatedUpdateDatetime, 'reason' => $reason, 'refundable' => $refundable, 'details' => $details, 'shippingAddressEmail' => $shippingAddressEmail, 'carrierTrackingId' => $carrierTrackingId, 'carrierType' => $carrierType, 'shippingAddressCountry' => $shippingAddressCountry, 'shippingAddressCity' => $shippingAddressCity, 'shippingAddressZip' => $shippingAddressZip, 'shippingAddressState' => $shippingAddressState, 'shippingAddressStreet' => $shippingAddressStreet, 'shippingAddressPhone' => $shippingAddressPhone, 'shippingAddressFirstname' => $shippingAddressFirstname, 'shippingAddressLastname' => $shippingAddressLastname, 'attachments' => $attachments], Response\ConfirmPaymentwallDeliveryResponse::class, true);
    }
}
