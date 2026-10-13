<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 빌링키 API 작업을 제공합니다.
 */
final class BillingKeyClient extends AbstractClient
{
    /**
     * 빌링키 발급 수동 승인 기능입니다.
     * 수동 승인으로 설정된 빌링키 발급에 대해, 빌링키 발급을 완료 처리합니다.
     */
    public function confirmBillingKey(?string $billingIssueToken = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\ConfirmedBillingKeySummary
    {
        return $this->callOperation('confirmBillingKey', 'POST', '/billing-keys/confirm', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedBillingKeySummary::class, true);
    }

    /**
     * 빌링키 발급 수동 승인 기능입니다.
     * 수동 승인으로 설정된 빌링키 발급에 대해, 빌링키 발급을 완료 처리합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function confirmBillingKeyAsync(?string $billingIssueToken = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('confirmBillingKey', 'POST', '/billing-keys/confirm', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedBillingKeySummary::class, true);
    }

    /**
     * 빌링키 발급 및 초회 결제 수동 승인 기능입니다.
     * 수동 승인으로 설정된 빌링키 발급 및 초회 결제에 대해, 빌링키 발급과 결제를 완료 처리합니다.
     */
    public function confirmBillingKeyIssueAndPay(?string $billingIssueToken = null, ?string $paymentId = null, ?string $currency = null, ?int $totalAmount = null, ?int $taxFreeAmount = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\ConfirmedBillingKeyIssueAndPaySummary
    {
        return $this->callOperation('confirmBillingKeyIssueAndPay', 'POST', '/billing-keys/confirm-issue-and-pay', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'paymentId' => $paymentId, 'currency' => $currency, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedBillingKeyIssueAndPaySummary::class, true);
    }

    /**
     * 빌링키 발급 및 초회 결제 수동 승인 기능입니다.
     * 수동 승인으로 설정된 빌링키 발급 및 초회 결제에 대해, 빌링키 발급과 결제를 완료 처리합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function confirmBillingKeyIssueAndPayAsync(?string $billingIssueToken = null, ?string $paymentId = null, ?string $currency = null, ?int $totalAmount = null, ?int $taxFreeAmount = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('confirmBillingKeyIssueAndPay', 'POST', '/billing-keys/confirm-issue-and-pay', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'paymentId' => $paymentId, 'currency' => $currency, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedBillingKeyIssueAndPaySummary::class, true);
    }

    /**
     * 빌링키 삭제 기능입니다.
     * 빌링키를 삭제합니다.
     */
    public function deleteBillingKey(?string $billingKey = null, ?string $reason = null, ?string $requester = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\DeleteBillingKeyResponse
    {
        return $this->callOperation('deleteBillingKey', 'DELETE', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey, 'reason' => $reason, 'requester' => $requester, 'skipWebhook' => $skipWebhook], Model\DeleteBillingKeyResponse::class, false);
    }

    /**
     * 빌링키 삭제 기능입니다.
     * 빌링키를 삭제합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function deleteBillingKeyAsync(?string $billingKey = null, ?string $reason = null, ?string $requester = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('deleteBillingKey', 'DELETE', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey, 'reason' => $reason, 'requester' => $requester, 'skipWebhook' => $skipWebhook], Model\DeleteBillingKeyResponse::class, false);
    }

    /**
     * 빌링키 단건 조회 기능입니다.
     * 주어진 빌링키에 대응되는 빌링키 정보를 조회합니다.
     */
    public function getBillingKeyInfo(?string $billingKey = null, ?string $storeId = null): Model\BillingKeyInfo
    {
        return $this->callOperation('getBillingKeyInfo', 'GET', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey], Model\BillingKeyInfo::class, false);
    }

    /**
     * 빌링키 단건 조회 기능입니다.
     * 주어진 빌링키에 대응되는 빌링키 정보를 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getBillingKeyInfoAsync(?string $billingKey = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getBillingKeyInfo', 'GET', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey], Model\BillingKeyInfo::class, false);
    }

    /**
     * 빌링키 다건 조회 기능입니다.
     * 주어진 조건에 맞는 빌링키들을 페이지 기반으로 조회합니다.
     */
    public function getBillingKeyInfos(?array $page = null, ?array $sort = null, ?array $filter = null): Model\GetBillingKeyInfosResponse
    {
        return $this->callOperation('getBillingKeyInfos', 'GET', '/billing-keys', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetBillingKeyInfosResponse::class, true);
    }

    /**
     * 빌링키 다건 조회 기능입니다.
     * 주어진 조건에 맞는 빌링키들을 페이지 기반으로 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getBillingKeyInfosAsync(?array $page = null, ?array $sort = null, ?array $filter = null): Future
    {
        return $this->callOperationAsync('getBillingKeyInfos', 'GET', '/billing-keys', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetBillingKeyInfosResponse::class, true);
    }

    /**
     * 빌링키 발급 기능입니다.
     * 빌링키 발급을 요청합니다.
     */
    public function issueBillingKey(?array $method = null, ?string $channelKey = null, ?string $channelGroupId = null, ?array $customer = null, ?string $customData = null, ?array $bypass = null, ?array $noticeUrls = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\IssueBillingKeyResponse
    {
        return $this->callOperation('issueBillingKey', 'POST', '/billing-keys', ['storeId' => $storeId, 'method' => $method, 'channelKey' => $channelKey, 'channelGroupId' => $channelGroupId, 'customer' => $customer, 'customData' => $customData, 'bypass' => $bypass, 'noticeUrls' => $noticeUrls, 'skipWebhook' => $skipWebhook], Model\IssueBillingKeyResponse::class, true);
    }

    /**
     * 빌링키 발급 기능입니다.
     * 빌링키 발급을 요청합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function issueBillingKeyAsync(?array $method = null, ?string $channelKey = null, ?string $channelGroupId = null, ?array $customer = null, ?string $customData = null, ?array $bypass = null, ?array $noticeUrls = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('issueBillingKey', 'POST', '/billing-keys', ['storeId' => $storeId, 'method' => $method, 'channelKey' => $channelKey, 'channelGroupId' => $channelGroupId, 'customer' => $customer, 'customData' => $customData, 'bypass' => $bypass, 'noticeUrls' => $noticeUrls, 'skipWebhook' => $skipWebhook], Model\IssueBillingKeyResponse::class, true);
    }
}
