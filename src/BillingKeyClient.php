<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class BillingKeyClient extends AbstractClient
{
    public function confirmBillingKey(mixed $billingIssueToken = null, mixed $isTest = null, mixed $skipWebhook = null, mixed $storeId = null): Response\ConfirmedBillingKeySummary
    {
        return $this->callOperation('confirmBillingKey', 'POST', '/billing-keys/confirm', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Response\ConfirmedBillingKeySummary::class, true);
    }

    public function confirmBillingKeyAsync(mixed $billingIssueToken = null, mixed $isTest = null, mixed $skipWebhook = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('confirmBillingKey', 'POST', '/billing-keys/confirm', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Response\ConfirmedBillingKeySummary::class, true);
    }

    public function confirmBillingKeyIssueAndPay(mixed $billingIssueToken = null, mixed $paymentId = null, mixed $currency = null, mixed $totalAmount = null, mixed $taxFreeAmount = null, mixed $isTest = null, mixed $skipWebhook = null, mixed $storeId = null): Response\ConfirmedBillingKeyIssueAndPaySummary
    {
        return $this->callOperation('confirmBillingKeyIssueAndPay', 'POST', '/billing-keys/confirm-issue-and-pay', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'paymentId' => $paymentId, 'currency' => $currency, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Response\ConfirmedBillingKeyIssueAndPaySummary::class, true);
    }

    public function confirmBillingKeyIssueAndPayAsync(mixed $billingIssueToken = null, mixed $paymentId = null, mixed $currency = null, mixed $totalAmount = null, mixed $taxFreeAmount = null, mixed $isTest = null, mixed $skipWebhook = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('confirmBillingKeyIssueAndPay', 'POST', '/billing-keys/confirm-issue-and-pay', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'paymentId' => $paymentId, 'currency' => $currency, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Response\ConfirmedBillingKeyIssueAndPaySummary::class, true);
    }

    public function deleteBillingKey(mixed $billingKey = null, mixed $reason = null, mixed $requester = null, mixed $skipWebhook = null, mixed $storeId = null): Response\DeleteBillingKeyResponse
    {
        return $this->callOperation('deleteBillingKey', 'DELETE', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey, 'reason' => $reason, 'requester' => $requester, 'skipWebhook' => $skipWebhook], Response\DeleteBillingKeyResponse::class, false);
    }

    public function deleteBillingKeyAsync(mixed $billingKey = null, mixed $reason = null, mixed $requester = null, mixed $skipWebhook = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('deleteBillingKey', 'DELETE', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey, 'reason' => $reason, 'requester' => $requester, 'skipWebhook' => $skipWebhook], Response\DeleteBillingKeyResponse::class, false);
    }

    public function getBillingKeyInfo(mixed $billingKey = null, mixed $storeId = null): Response\BillingKeyInfo
    {
        return $this->callOperation('getBillingKeyInfo', 'GET', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey], Response\BillingKeyInfo::class, false);
    }

    public function getBillingKeyInfoAsync(mixed $billingKey = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('getBillingKeyInfo', 'GET', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey], Response\BillingKeyInfo::class, false);
    }

    public function getBillingKeyInfos(mixed $page = null, mixed $sort = null, mixed $filter = null): Response\GetBillingKeyInfosResponse
    {
        return $this->callOperation('getBillingKeyInfos', 'GET', '/billing-keys', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Response\GetBillingKeyInfosResponse::class, true);
    }

    public function getBillingKeyInfosAsync(mixed $page = null, mixed $sort = null, mixed $filter = null): Future
    {
        return $this->callOperationAsync('getBillingKeyInfos', 'GET', '/billing-keys', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Response\GetBillingKeyInfosResponse::class, true);
    }

    public function issueBillingKey(mixed $method = null, mixed $channelKey = null, mixed $channelGroupId = null, mixed $customer = null, mixed $customData = null, mixed $bypass = null, mixed $noticeUrls = null, mixed $skipWebhook = null, mixed $storeId = null): Response\IssueBillingKeyResponse
    {
        return $this->callOperation('issueBillingKey', 'POST', '/billing-keys', ['storeId' => $storeId, 'method' => $method, 'channelKey' => $channelKey, 'channelGroupId' => $channelGroupId, 'customer' => $customer, 'customData' => $customData, 'bypass' => $bypass, 'noticeUrls' => $noticeUrls, 'skipWebhook' => $skipWebhook], Response\IssueBillingKeyResponse::class, true);
    }

    public function issueBillingKeyAsync(mixed $method = null, mixed $channelKey = null, mixed $channelGroupId = null, mixed $customer = null, mixed $customData = null, mixed $bypass = null, mixed $noticeUrls = null, mixed $skipWebhook = null, mixed $storeId = null): Future
    {
        return $this->callOperationAsync('issueBillingKey', 'POST', '/billing-keys', ['storeId' => $storeId, 'method' => $method, 'channelKey' => $channelKey, 'channelGroupId' => $channelGroupId, 'customer' => $customer, 'customData' => $customData, 'bypass' => $bypass, 'noticeUrls' => $noticeUrls, 'skipWebhook' => $skipWebhook], Response\IssueBillingKeyResponse::class, true);
    }
}
