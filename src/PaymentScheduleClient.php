<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class PaymentScheduleClient extends AbstractClient
{
    public function createPaymentSchedule(mixed $paymentId = null, mixed $payment = null, mixed $timeToPay = null): Response\CreatePaymentScheduleResponse
    {
        return $this->callOperation('createPaymentSchedule', 'POST', '/payments/{paymentId}/schedule', ['paymentId' => $paymentId, 'payment' => $payment, 'timeToPay' => $timeToPay], Response\CreatePaymentScheduleResponse::class, true);
    }

    public function createPaymentScheduleAsync(mixed $paymentId = null, mixed $payment = null, mixed $timeToPay = null): Future
    {
        return $this->callOperationAsync('createPaymentSchedule', 'POST', '/payments/{paymentId}/schedule', ['paymentId' => $paymentId, 'payment' => $payment, 'timeToPay' => $timeToPay], Response\CreatePaymentScheduleResponse::class, true);
    }

    public function getPaymentSchedule(mixed $paymentScheduleId = null, mixed $storeId = null): Response\PaymentSchedule
    {
        return $this->callOperation('getPaymentSchedule', 'GET', '/payment-schedules/{paymentScheduleId}', ['storeId' => $storeId, 'paymentScheduleId' => $paymentScheduleId], Response\PaymentSchedule::class, false);
    }

    public function getPaymentScheduleAsync(mixed $paymentScheduleId = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('getPaymentSchedule', 'GET', '/payment-schedules/{paymentScheduleId}', ['storeId' => $storeId, 'paymentScheduleId' => $paymentScheduleId], Response\PaymentSchedule::class, false);
    }

    public function getPaymentSchedules(mixed $page = null, mixed $sort = null, mixed $filter = null): Response\GetPaymentSchedulesResponse
    {
        return $this->callOperation('getPaymentSchedules', 'GET', '/payment-schedules', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Response\GetPaymentSchedulesResponse::class, true);
    }

    public function getPaymentSchedulesAsync(mixed $page = null, mixed $sort = null, mixed $filter = null): Future
    {
        return $this->callOperationAsync('getPaymentSchedules', 'GET', '/payment-schedules', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Response\GetPaymentSchedulesResponse::class, true);
    }

    public function revokePaymentSchedules(mixed $billingKey = null, mixed $scheduleIds = null, mixed $storeId = null): Response\RevokePaymentSchedulesResponse
    {
        return $this->callOperationWithQueryRequestBody('revokePaymentSchedules', 'DELETE', '/payment-schedules', ['storeId' => $storeId], ['billingKey' => $billingKey, 'scheduleIds' => $scheduleIds], Response\RevokePaymentSchedulesResponse::class);
    }

    public function revokePaymentSchedulesAsync(mixed $billingKey = null, mixed $scheduleIds = null, mixed $storeId = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('revokePaymentSchedules', 'DELETE', '/payment-schedules', ['storeId' => $storeId], ['billingKey' => $billingKey, 'scheduleIds' => $scheduleIds], Response\RevokePaymentSchedulesResponse::class);
    }
}
