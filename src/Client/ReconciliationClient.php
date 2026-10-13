<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 결제 대사 API 작업을 제공합니다.
 */
final class ReconciliationClient extends AbstractClient
{
    /**
     * 정산일 기준 부가세 내역 조회 기능입니다.
     */
    public function getPaymentReconciliationSettlementVatReport(?array $dateRange = null, ?array $filter = null): Model\GetPaymentReconciliationSettlementVatReportResponse
    {
        return $this->callOperation('getPaymentReconciliationSettlementVatReport', 'GET', '/payment-reconciliations/settlements/vat-report', ['dateRange' => $dateRange, 'filter' => $filter], Model\GetPaymentReconciliationSettlementVatReportResponse::class, true);
    }

    /**
     * 정산일 기준 부가세 내역 조회 기능입니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPaymentReconciliationSettlementVatReportAsync(?array $dateRange = null, ?array $filter = null): Future
    {
        return $this->callOperationAsync('getPaymentReconciliationSettlementVatReport', 'GET', '/payment-reconciliations/settlements/vat-report', ['dateRange' => $dateRange, 'filter' => $filter], Model\GetPaymentReconciliationSettlementVatReportResponse::class, true);
    }

    /**
     * 거래일 기준 부가세 내역 조회 기능입니다.
     */
    public function getPaymentReconciliationTransactionVatReport(?array $dateRange = null, ?array $filter = null): Model\GetPaymentReconciliationTransactionVatReportResponse
    {
        return $this->callOperation('getPaymentReconciliationTransactionVatReport', 'GET', '/payment-reconciliations/transactions/vat-report', ['dateRange' => $dateRange, 'filter' => $filter], Model\GetPaymentReconciliationTransactionVatReportResponse::class, true);
    }

    /**
     * 거래일 기준 부가세 내역 조회 기능입니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPaymentReconciliationTransactionVatReportAsync(?array $dateRange = null, ?array $filter = null): Future
    {
        return $this->callOperationAsync('getPaymentReconciliationTransactionVatReport', 'GET', '/payment-reconciliations/transactions/vat-report', ['dateRange' => $dateRange, 'filter' => $filter], Model\GetPaymentReconciliationTransactionVatReportResponse::class, true);
    }
}
