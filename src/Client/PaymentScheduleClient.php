<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

final class PaymentScheduleClient extends AbstractClient
{
    public function createPaymentSchedule(?string $paymentId = null, ?array $payment = null, ?string $timeToPay = null): Model\CreatePaymentScheduleResponse
    {
        return $this->callOperation('createPaymentSchedule', 'POST', '/payments/{paymentId}/schedule', ['paymentId' => $paymentId, 'payment' => $payment, 'timeToPay' => $timeToPay], Model\CreatePaymentScheduleResponse::class, true);
    }

    public function createPaymentScheduleAsync(?string $paymentId = null, ?array $payment = null, ?string $timeToPay = null): Future
    {
        return $this->callOperationAsync('createPaymentSchedule', 'POST', '/payments/{paymentId}/schedule', ['paymentId' => $paymentId, 'payment' => $payment, 'timeToPay' => $timeToPay], Model\CreatePaymentScheduleResponse::class, true);
    }

    public function getPaymentSchedule(?string $paymentScheduleId = null, ?string $storeId = null): Model\PaymentSchedule
    {
        return $this->callOperation('getPaymentSchedule', 'GET', '/payment-schedules/{paymentScheduleId}', ['storeId' => $storeId, 'paymentScheduleId' => $paymentScheduleId], Model\PaymentSchedule::class, false);
    }

    public function getPaymentScheduleAsync(?string $paymentScheduleId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getPaymentSchedule', 'GET', '/payment-schedules/{paymentScheduleId}', ['storeId' => $storeId, 'paymentScheduleId' => $paymentScheduleId], Model\PaymentSchedule::class, false);
    }

    public function getPaymentSchedules(?array $page = null, ?array $sort = null, ?array $filter = null): Model\GetPaymentSchedulesResponse
    {
        return $this->callOperation('getPaymentSchedules', 'GET', '/payment-schedules', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetPaymentSchedulesResponse::class, true);
    }

    public function getPaymentSchedulesAsync(?array $page = null, ?array $sort = null, ?array $filter = null): Future
    {
        return $this->callOperationAsync('getPaymentSchedules', 'GET', '/payment-schedules', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetPaymentSchedulesResponse::class, true);
    }

    public function revokePaymentSchedules(?string $billingKey = null, ?array $scheduleIds = null, ?string $storeId = null): Model\RevokePaymentSchedulesResponse
    {
        return $this->callOperationWithQueryRequestBody('revokePaymentSchedules', 'DELETE', '/payment-schedules', ['storeId' => $storeId], ['billingKey' => $billingKey, 'scheduleIds' => $scheduleIds], Model\RevokePaymentSchedulesResponse::class);
    }

    public function revokePaymentSchedulesAsync(?string $billingKey = null, ?array $scheduleIds = null, ?string $storeId = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('revokePaymentSchedules', 'DELETE', '/payment-schedules', ['storeId' => $storeId], ['billingKey' => $billingKey, 'scheduleIds' => $scheduleIds], Model\RevokePaymentSchedulesResponse::class);
    }
}
