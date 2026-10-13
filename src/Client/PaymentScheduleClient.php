<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 결제 예약 API 작업을 제공합니다.
 */
final class PaymentScheduleClient extends AbstractClient
{
    /**
     * 결제 예약 기능입니다.
     * 결제를 예약합니다.
     */
    public function createPaymentSchedule(?string $paymentId = null, ?array $payment = null, ?string $timeToPay = null): Model\CreatePaymentScheduleResponse
    {
        return $this->callOperation('createPaymentSchedule', 'POST', '/payments/{paymentId}/schedule', ['paymentId' => $paymentId, 'payment' => $payment, 'timeToPay' => $timeToPay], Model\CreatePaymentScheduleResponse::class, true);
    }

    /**
     * 결제 예약 기능입니다.
     * 결제를 예약합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function createPaymentScheduleAsync(?string $paymentId = null, ?array $payment = null, ?string $timeToPay = null): Future
    {
        return $this->callOperationAsync('createPaymentSchedule', 'POST', '/payments/{paymentId}/schedule', ['paymentId' => $paymentId, 'payment' => $payment, 'timeToPay' => $timeToPay], Model\CreatePaymentScheduleResponse::class, true);
    }

    /**
     * 결제 예약 단건 조회 기능입니다.
     * 주어진 아이디에 대응되는 결제 예약 건을 조회합니다.
     */
    public function getPaymentSchedule(?string $paymentScheduleId = null, ?string $storeId = null): Model\PaymentSchedule
    {
        return $this->callOperation('getPaymentSchedule', 'GET', '/payment-schedules/{paymentScheduleId}', ['storeId' => $storeId, 'paymentScheduleId' => $paymentScheduleId], Model\PaymentSchedule::class, false);
    }

    /**
     * 결제 예약 단건 조회 기능입니다.
     * 주어진 아이디에 대응되는 결제 예약 건을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPaymentScheduleAsync(?string $paymentScheduleId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getPaymentSchedule', 'GET', '/payment-schedules/{paymentScheduleId}', ['storeId' => $storeId, 'paymentScheduleId' => $paymentScheduleId], Model\PaymentSchedule::class, false);
    }

    /**
     * 결제 예약 다건 조회 기능입니다.
     * 주어진 조건에 맞는 결제 예약 건들을 조회합니다.
`filter.from`, `filter.until` 파라미터의 기본값이 결제 시점 기준 지난 90일에 속하는 건을 조회하도록 되어 있으니, 미래 예약 상태의 건을 조회하기 위해서는 해당 파라미터를 직접 설정해 주셔야 합니다.
     */
    public function getPaymentSchedules(?array $page = null, ?array $sort = null, ?array $filter = null): Model\GetPaymentSchedulesResponse
    {
        return $this->callOperation('getPaymentSchedules', 'GET', '/payment-schedules', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetPaymentSchedulesResponse::class, true);
    }

    /**
     * 결제 예약 다건 조회 기능입니다.
     * 주어진 조건에 맞는 결제 예약 건들을 조회합니다.
`filter.from`, `filter.until` 파라미터의 기본값이 결제 시점 기준 지난 90일에 속하는 건을 조회하도록 되어 있으니, 미래 예약 상태의 건을 조회하기 위해서는 해당 파라미터를 직접 설정해 주셔야 합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPaymentSchedulesAsync(?array $page = null, ?array $sort = null, ?array $filter = null): Future
    {
        return $this->callOperationAsync('getPaymentSchedules', 'GET', '/payment-schedules', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetPaymentSchedulesResponse::class, true);
    }

    /**
     * 결제 예약 취소 기능입니다.
     * 결제 예약 건을 취소합니다.
billingKey, scheduleIds 중 하나 이상은 필수로 입력합니다.
billingKey 만 입력된 경우 -> 해당 빌링키로 예약된 모든 결제 예약 건들이 취소됩니다.
scheduleIds 만 입력된 경우 -> 입력된 결제 예약 건 아이디에 해당하는 예약 건들이 취소됩니다.
billingKey, scheduleIds 모두 입력된 경우 -> 입력된 결제 예약 건 아이디에 해당하는 예약 건들이 취소됩니다. 단, 예약한 빌링키가 입력된 빌링키와 일치하지 않으면 실패합니다.
위 정책에 따라 선택된 결제 예약 건들 중 하나라도 취소에 실패할 경우, 모든 취소 요청이 실패합니다.
     */
    public function revokePaymentSchedules(?string $billingKey = null, ?array $scheduleIds = null, ?string $storeId = null): Model\RevokePaymentSchedulesResponse
    {
        return $this->callOperationWithQueryRequestBody('revokePaymentSchedules', 'DELETE', '/payment-schedules', ['storeId' => $storeId], ['billingKey' => $billingKey, 'scheduleIds' => $scheduleIds], Model\RevokePaymentSchedulesResponse::class);
    }

    /**
     * 결제 예약 취소 기능입니다.
     * 결제 예약 건을 취소합니다.
billingKey, scheduleIds 중 하나 이상은 필수로 입력합니다.
billingKey 만 입력된 경우 -> 해당 빌링키로 예약된 모든 결제 예약 건들이 취소됩니다.
scheduleIds 만 입력된 경우 -> 입력된 결제 예약 건 아이디에 해당하는 예약 건들이 취소됩니다.
billingKey, scheduleIds 모두 입력된 경우 -> 입력된 결제 예약 건 아이디에 해당하는 예약 건들이 취소됩니다. 단, 예약한 빌링키가 입력된 빌링키와 일치하지 않으면 실패합니다.
위 정책에 따라 선택된 결제 예약 건들 중 하나라도 취소에 실패할 경우, 모든 취소 요청이 실패합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function revokePaymentSchedulesAsync(?string $billingKey = null, ?array $scheduleIds = null, ?string $storeId = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('revokePaymentSchedules', 'DELETE', '/payment-schedules', ['storeId' => $storeId], ['billingKey' => $billingKey, 'scheduleIds' => $scheduleIds], Model\RevokePaymentSchedulesResponse::class);
    }
}
