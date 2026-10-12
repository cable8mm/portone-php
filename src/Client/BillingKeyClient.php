<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

final class BillingKeyClient extends AbstractClient
{
    public function confirmBillingKey(?string $billingIssueToken = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\ConfirmedBillingKeySummary
    {
        return $this->callOperation('confirmBillingKey', 'POST', '/billing-keys/confirm', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedBillingKeySummary::class, true);
    }

    public function confirmBillingKeyAsync(?string $billingIssueToken = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('confirmBillingKey', 'POST', '/billing-keys/confirm', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedBillingKeySummary::class, true);
    }

    public function confirmBillingKeyIssueAndPay(?string $billingIssueToken = null, ?string $paymentId = null, ?string $currency = null, ?int $totalAmount = null, ?int $taxFreeAmount = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\ConfirmedBillingKeyIssueAndPaySummary
    {
        return $this->callOperation('confirmBillingKeyIssueAndPay', 'POST', '/billing-keys/confirm-issue-and-pay', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'paymentId' => $paymentId, 'currency' => $currency, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedBillingKeyIssueAndPaySummary::class, true);
    }

    public function confirmBillingKeyIssueAndPayAsync(?string $billingIssueToken = null, ?string $paymentId = null, ?string $currency = null, ?int $totalAmount = null, ?int $taxFreeAmount = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('confirmBillingKeyIssueAndPay', 'POST', '/billing-keys/confirm-issue-and-pay', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'paymentId' => $paymentId, 'currency' => $currency, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedBillingKeyIssueAndPaySummary::class, true);
    }

    public function deleteBillingKey(?string $billingKey = null, ?string $reason = null, ?string $requester = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\DeleteBillingKeyResponse
    {
        return $this->callOperation('deleteBillingKey', 'DELETE', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey, 'reason' => $reason, 'requester' => $requester, 'skipWebhook' => $skipWebhook], Model\DeleteBillingKeyResponse::class, false);
    }

    public function deleteBillingKeyAsync(?string $billingKey = null, ?string $reason = null, ?string $requester = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('deleteBillingKey', 'DELETE', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey, 'reason' => $reason, 'requester' => $requester, 'skipWebhook' => $skipWebhook], Model\DeleteBillingKeyResponse::class, false);
    }

    public function getBillingKeyInfo(?string $billingKey = null, ?string $storeId = null): Model\BillingKeyInfo
    {
        return $this->callOperation('getBillingKeyInfo', 'GET', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey], Model\BillingKeyInfo::class, false);
    }

    public function getBillingKeyInfoAsync(?string $billingKey = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getBillingKeyInfo', 'GET', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey], Model\BillingKeyInfo::class, false);
    }

    public function getBillingKeyInfos(?array $page = null, ?array $sort = null, ?array $filter = null): Model\GetBillingKeyInfosResponse
    {
        return $this->callOperation('getBillingKeyInfos', 'GET', '/billing-keys', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetBillingKeyInfosResponse::class, true);
    }

    public function getBillingKeyInfosAsync(?array $page = null, ?array $sort = null, ?array $filter = null): Future
    {
        return $this->callOperationAsync('getBillingKeyInfos', 'GET', '/billing-keys', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetBillingKeyInfosResponse::class, true);
    }

    public function issueBillingKey(?array $method = null, ?string $channelKey = null, ?string $channelGroupId = null, ?array $customer = null, ?string $customData = null, ?array $bypass = null, ?array $noticeUrls = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\IssueBillingKeyResponse
    {
        return $this->callOperation('issueBillingKey', 'POST', '/billing-keys', ['storeId' => $storeId, 'method' => $method, 'channelKey' => $channelKey, 'channelGroupId' => $channelGroupId, 'customer' => $customer, 'customData' => $customData, 'bypass' => $bypass, 'noticeUrls' => $noticeUrls, 'skipWebhook' => $skipWebhook], Model\IssueBillingKeyResponse::class, true);
    }

    public function issueBillingKeyAsync(?array $method = null, ?string $channelKey = null, ?string $channelGroupId = null, ?array $customer = null, ?string $customData = null, ?array $bypass = null, ?array $noticeUrls = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('issueBillingKey', 'POST', '/billing-keys', ['storeId' => $storeId, 'method' => $method, 'channelKey' => $channelKey, 'channelGroupId' => $channelGroupId, 'customer' => $customer, 'customData' => $customData, 'bypass' => $bypass, 'noticeUrls' => $noticeUrls, 'skipWebhook' => $skipWebhook], Model\IssueBillingKeyResponse::class, true);
    }
}
