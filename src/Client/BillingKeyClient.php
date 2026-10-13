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
     *
     * @param  string|null  $billingIssueToken  빌링키 발급 토큰: 빌링키 발급 요청 완료 시 발급된 토큰입니다.
     * @param  bool|null  $isTest  테스트 결제 여부: 검증용 파라미터로, 결제 건 테스트 여부와 일치하지 않을 경우 오류가 반환됩니다.
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 빌링키 발급이 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function confirmBillingKey(?string $billingIssueToken = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\ConfirmedBillingKeySummary
    {
        return $this->callOperation('confirmBillingKey', 'POST', '/billing-keys/confirm', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedBillingKeySummary::class, true);
    }

    /**
     * 빌링키 발급 수동 승인 기능입니다.
     * 수동 승인으로 설정된 빌링키 발급에 대해, 빌링키 발급을 완료 처리합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $billingIssueToken  빌링키 발급 토큰: 빌링키 발급 요청 완료 시 발급된 토큰입니다.
     * @param  bool|null  $isTest  테스트 결제 여부: 검증용 파라미터로, 결제 건 테스트 여부와 일치하지 않을 경우 오류가 반환됩니다.
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 빌링키 발급이 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function confirmBillingKeyAsync(?string $billingIssueToken = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('confirmBillingKey', 'POST', '/billing-keys/confirm', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedBillingKeySummary::class, true);
    }

    /**
     * 빌링키 발급 및 초회 결제 수동 승인 기능입니다.
     * 수동 승인으로 설정된 빌링키 발급 및 초회 결제에 대해, 빌링키 발급과 결제를 완료 처리합니다.
     *
     * @param  string|null  $billingIssueToken  빌링키 발급 토큰: 빌링키 발급 및 초회 결제 요청 완료 시 발급된 토큰입니다.
     * @param  string|null  $paymentId  검증용 파라미터로, 결제 건 아이디와 일치하지 않을 경우 오류가 반환됩니다.
     * @param  string|null  $currency  통화: 검증용 파라미터로, 결제 건 화폐와 일치하지 않을 경우 오류가 반환됩니다.
     * @param  int|null  $totalAmount  결제 금액: 검증용 파라미터로, 결제 건 총 금액과 일치하지 않을 경우 오류가 반환됩니다.
     * @param  int|null  $taxFreeAmount  검증용 파라미터로, 결제 건 면세 금액과 일치하지 않을 경우 오류가 반환됩니다.
     * @param  bool|null  $isTest  테스트 결제 여부: 검증용 파라미터로, 결제 건 테스트 여부와 일치하지 않을 경우 오류가 반환됩니다.
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 빌링키 발급 및 결제가 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다. 가상계좌 입금 완료 등 외부 이벤트로 결제가 완료되는 경우 발생하는 웹훅은 스킵되지 않습니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function confirmBillingKeyIssueAndPay(?string $billingIssueToken = null, ?string $paymentId = null, ?string $currency = null, ?int $totalAmount = null, ?int $taxFreeAmount = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\ConfirmedBillingKeyIssueAndPaySummary
    {
        return $this->callOperation('confirmBillingKeyIssueAndPay', 'POST', '/billing-keys/confirm-issue-and-pay', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'paymentId' => $paymentId, 'currency' => $currency, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedBillingKeyIssueAndPaySummary::class, true);
    }

    /**
     * 빌링키 발급 및 초회 결제 수동 승인 기능입니다.
     * 수동 승인으로 설정된 빌링키 발급 및 초회 결제에 대해, 빌링키 발급과 결제를 완료 처리합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $billingIssueToken  빌링키 발급 토큰: 빌링키 발급 및 초회 결제 요청 완료 시 발급된 토큰입니다.
     * @param  string|null  $paymentId  검증용 파라미터로, 결제 건 아이디와 일치하지 않을 경우 오류가 반환됩니다.
     * @param  string|null  $currency  통화: 검증용 파라미터로, 결제 건 화폐와 일치하지 않을 경우 오류가 반환됩니다.
     * @param  int|null  $totalAmount  결제 금액: 검증용 파라미터로, 결제 건 총 금액과 일치하지 않을 경우 오류가 반환됩니다.
     * @param  int|null  $taxFreeAmount  검증용 파라미터로, 결제 건 면세 금액과 일치하지 않을 경우 오류가 반환됩니다.
     * @param  bool|null  $isTest  테스트 결제 여부: 검증용 파라미터로, 결제 건 테스트 여부와 일치하지 않을 경우 오류가 반환됩니다.
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 빌링키 발급 및 결제가 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다. 가상계좌 입금 완료 등 외부 이벤트로 결제가 완료되는 경우 발생하는 웹훅은 스킵되지 않습니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function confirmBillingKeyIssueAndPayAsync(?string $billingIssueToken = null, ?string $paymentId = null, ?string $currency = null, ?int $totalAmount = null, ?int $taxFreeAmount = null, ?bool $isTest = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('confirmBillingKeyIssueAndPay', 'POST', '/billing-keys/confirm-issue-and-pay', ['storeId' => $storeId, 'billingIssueToken' => $billingIssueToken, 'paymentId' => $paymentId, 'currency' => $currency, 'totalAmount' => $totalAmount, 'taxFreeAmount' => $taxFreeAmount, 'isTest' => $isTest, 'skipWebhook' => $skipWebhook], Model\ConfirmedBillingKeyIssueAndPaySummary::class, true);
    }

    /**
     * 빌링키 삭제 기능입니다.
     * 빌링키를 삭제합니다.
     *
     * @param  string|null  $billingKey  삭제할 빌링키
     * @param  string|null  $reason  네이버페이: 자동결제 해지 사유입니다. 명시가 필요합니다.
     * @param  string|null  $requester  네이버페이: 자동결제 해지 요청 주체입니다. 명시가 필요합니다.
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 빌링키 삭제가 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function deleteBillingKey(?string $billingKey = null, ?string $reason = null, ?string $requester = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\DeleteBillingKeyResponse
    {
        return $this->callOperation('deleteBillingKey', 'DELETE', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey, 'reason' => $reason, 'requester' => $requester, 'skipWebhook' => $skipWebhook], Model\DeleteBillingKeyResponse::class, false);
    }

    /**
     * 빌링키 삭제 기능입니다.
     * 빌링키를 삭제합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $billingKey  삭제할 빌링키
     * @param  string|null  $reason  네이버페이: 자동결제 해지 사유입니다. 명시가 필요합니다.
     * @param  string|null  $requester  네이버페이: 자동결제 해지 요청 주체입니다. 명시가 필요합니다.
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 빌링키 삭제가 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function deleteBillingKeyAsync(?string $billingKey = null, ?string $reason = null, ?string $requester = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('deleteBillingKey', 'DELETE', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey, 'reason' => $reason, 'requester' => $requester, 'skipWebhook' => $skipWebhook], Model\DeleteBillingKeyResponse::class, false);
    }

    /**
     * 빌링키 단건 조회 기능입니다.
     * 주어진 빌링키에 대응되는 빌링키 정보를 조회합니다.
     *
     * @param  string|null  $billingKey  조회할 빌링키
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function getBillingKeyInfo(?string $billingKey = null, ?string $storeId = null): Model\BillingKeyInfo
    {
        return $this->callOperation('getBillingKeyInfo', 'GET', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey], Model\BillingKeyInfo::class, false);
    }

    /**
     * 빌링키 단건 조회 기능입니다.
     * 주어진 빌링키에 대응되는 빌링키 정보를 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $billingKey  조회할 빌링키
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function getBillingKeyInfoAsync(?string $billingKey = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getBillingKeyInfo', 'GET', '/billing-keys/{billingKey}', ['storeId' => $storeId, 'billingKey' => $billingKey], Model\BillingKeyInfo::class, false);
    }

    /**
     * 빌링키 다건 조회 기능입니다.
     * 주어진 조건에 맞는 빌링키들을 페이지 기반으로 조회합니다.
     *
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보: 미 입력 시 number: 0, size: 10 으로 기본값이 적용됩니다.
     * @param  array<string, mixed>|null  $sort  빌링키 다건 조회 시 정렬 조건: 미 입력 시 sortBy: TIME_TO_PAY, sortOrder: DESC 으로 기본값이 적용됩니다.
     * @param  array<string, mixed>|null  $filter  빌링키 다건 조회를 위한 입력 정보: V1 빌링키 건의 경우 일부 필드에 대해 필터가 적용되지 않을 수 있습니다.
     */
    public function getBillingKeyInfos(?array $page = null, ?array $sort = null, ?array $filter = null): Model\GetBillingKeyInfosResponse
    {
        return $this->callOperation('getBillingKeyInfos', 'GET', '/billing-keys', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetBillingKeyInfosResponse::class, true);
    }

    /**
     * 빌링키 다건 조회 기능입니다.
     * 주어진 조건에 맞는 빌링키들을 페이지 기반으로 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보: 미 입력 시 number: 0, size: 10 으로 기본값이 적용됩니다.
     * @param  array<string, mixed>|null  $sort  빌링키 다건 조회 시 정렬 조건: 미 입력 시 sortBy: TIME_TO_PAY, sortOrder: DESC 으로 기본값이 적용됩니다.
     * @param  array<string, mixed>|null  $filter  빌링키 다건 조회를 위한 입력 정보: V1 빌링키 건의 경우 일부 필드에 대해 필터가 적용되지 않을 수 있습니다.
     */
    public function getBillingKeyInfosAsync(?array $page = null, ?array $sort = null, ?array $filter = null): Future
    {
        return $this->callOperationAsync('getBillingKeyInfos', 'GET', '/billing-keys', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetBillingKeyInfosResponse::class, true);
    }

    /**
     * 빌링키 발급 기능입니다.
     * 빌링키 발급을 요청합니다.
     *
     * @param  array<string, mixed>|null  $method  빌링키 발급 시 결제 수단 입력 양식: `card`를 반드시 입력해 주세요.
     * @param  string|null  $channelKey  채널 키 또는 채널 그룹 ID 필수
     * @param  string|null  $channelGroupId  채널 키 또는 채널 그룹 ID 필수
     * @param  array<string, mixed>|null  $customer  고객 정보 입력 정보
     * @param  string|null  $customData  사용자 지정 데이터
     * @param  array<string, mixed>|null  $bypass  PG사별 추가 파라미터 ("PG사별 연동 가이드" 참고)
     * @param  array<string, mixed>|null  $noticeUrls  빌링키 발급 시 요청을 받을 웹훅 주소입니다. 상점에 설정되어 있는 값보다 우선적으로 적용됩니다. 입력된 값이 없을 경우에는 빈 배열로 해석됩니다.
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 빌링키 발급이 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function issueBillingKey(?array $method = null, ?string $channelKey = null, ?string $channelGroupId = null, ?array $customer = null, ?string $customData = null, ?array $bypass = null, ?array $noticeUrls = null, ?bool $skipWebhook = null, ?string $storeId = null): Model\IssueBillingKeyResponse
    {
        return $this->callOperation('issueBillingKey', 'POST', '/billing-keys', ['storeId' => $storeId, 'method' => $method, 'channelKey' => $channelKey, 'channelGroupId' => $channelGroupId, 'customer' => $customer, 'customData' => $customData, 'bypass' => $bypass, 'noticeUrls' => $noticeUrls, 'skipWebhook' => $skipWebhook], Model\IssueBillingKeyResponse::class, true);
    }

    /**
     * 빌링키 발급 기능입니다.
     * 빌링키 발급을 요청합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  array<string, mixed>|null  $method  빌링키 발급 시 결제 수단 입력 양식: `card`를 반드시 입력해 주세요.
     * @param  string|null  $channelKey  채널 키 또는 채널 그룹 ID 필수
     * @param  string|null  $channelGroupId  채널 키 또는 채널 그룹 ID 필수
     * @param  array<string, mixed>|null  $customer  고객 정보 입력 정보
     * @param  string|null  $customData  사용자 지정 데이터
     * @param  array<string, mixed>|null  $bypass  PG사별 추가 파라미터 ("PG사별 연동 가이드" 참고)
     * @param  array<string, mixed>|null  $noticeUrls  빌링키 발급 시 요청을 받을 웹훅 주소입니다. 상점에 설정되어 있는 값보다 우선적으로 적용됩니다. 입력된 값이 없을 경우에는 빈 배열로 해석됩니다.
     * @param  bool|null  $skipWebhook  웹훅 생략 여부: 빌링키 발급이 성공했을 때 웹훅을 전송하지 않으려면 true로 설정합니다.
     * @param  string|null  $storeId  접근 권한이 있는 상점 아이디만 입력 가능하며, 미입력시 인증 정보의 상점 아이디를 사용합니다.
     */
    public function issueBillingKeyAsync(?array $method = null, ?string $channelKey = null, ?string $channelGroupId = null, ?array $customer = null, ?string $customData = null, ?array $bypass = null, ?array $noticeUrls = null, ?bool $skipWebhook = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('issueBillingKey', 'POST', '/billing-keys', ['storeId' => $storeId, 'method' => $method, 'channelKey' => $channelKey, 'channelGroupId' => $channelGroupId, 'customer' => $customer, 'customData' => $customData, 'bypass' => $bypass, 'noticeUrls' => $noticeUrls, 'skipWebhook' => $skipWebhook], Model\IssueBillingKeyResponse::class, true);
    }
}
