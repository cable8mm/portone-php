<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class ReconciliationClient extends AbstractClient
{
    public function getPaymentReconciliationSettlementVatReport(?array $dateRange = null, ?array $filter = null): Response\GetPaymentReconciliationSettlementVatReportResponse
    {
        return $this->callOperation('getPaymentReconciliationSettlementVatReport', 'GET', '/payment-reconciliations/settlements/vat-report', ['dateRange' => $dateRange, 'filter' => $filter], Response\GetPaymentReconciliationSettlementVatReportResponse::class, true);
    }

    public function getPaymentReconciliationSettlementVatReportAsync(?array $dateRange = null, ?array $filter = null): Future
    {
        return $this->callOperationAsync('getPaymentReconciliationSettlementVatReport', 'GET', '/payment-reconciliations/settlements/vat-report', ['dateRange' => $dateRange, 'filter' => $filter], Response\GetPaymentReconciliationSettlementVatReportResponse::class, true);
    }

    public function getPaymentReconciliationTransactionVatReport(?array $dateRange = null, ?array $filter = null): Response\GetPaymentReconciliationTransactionVatReportResponse
    {
        return $this->callOperation('getPaymentReconciliationTransactionVatReport', 'GET', '/payment-reconciliations/transactions/vat-report', ['dateRange' => $dateRange, 'filter' => $filter], Response\GetPaymentReconciliationTransactionVatReportResponse::class, true);
    }

    public function getPaymentReconciliationTransactionVatReportAsync(?array $dateRange = null, ?array $filter = null): Future
    {
        return $this->callOperationAsync('getPaymentReconciliationTransactionVatReport', 'GET', '/payment-reconciliations/transactions/vat-report', ['dateRange' => $dateRange, 'filter' => $filter], Response\GetPaymentReconciliationTransactionVatReportResponse::class, true);
    }
}
