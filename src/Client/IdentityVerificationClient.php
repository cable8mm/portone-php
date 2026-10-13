<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 본인인증 API 작업을 제공합니다.
 */
final class IdentityVerificationClient extends AbstractClient
{
    /**
     * 본인인증 확인 기능입니다.
     * 요청된 본인인증에 대한 확인을 진행합니다.
     */
    public function confirmIdentityVerification(?string $identityVerificationId = null, ?string $otp = null, ?string $storeId = null): Model\ConfirmIdentityVerificationResponse
    {
        return $this->callOperation('confirmIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/confirm', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId, 'otp' => $otp], Model\ConfirmIdentityVerificationResponse::class, true);
    }

    /**
     * 본인인증 확인 기능입니다.
     * 요청된 본인인증에 대한 확인을 진행합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function confirmIdentityVerificationAsync(?string $identityVerificationId = null, ?string $otp = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('confirmIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/confirm', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId, 'otp' => $otp], Model\ConfirmIdentityVerificationResponse::class, true);
    }

    /**
     * 본인인증 단건 조회 기능입니다.
     * 주어진 아이디에 대응되는 본인인증 내역을 조회합니다.
     */
    public function getIdentityVerification(?string $identityVerificationId = null, ?string $storeId = null): Model\IdentityVerification
    {
        return $this->callOperation('getIdentityVerification', 'GET', '/identity-verifications/{identityVerificationId}', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId], Model\IdentityVerification::class, false);
    }

    /**
     * 본인인증 단건 조회 기능입니다.
     * 주어진 아이디에 대응되는 본인인증 내역을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getIdentityVerificationAsync(?string $identityVerificationId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getIdentityVerification', 'GET', '/identity-verifications/{identityVerificationId}', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId], Model\IdentityVerification::class, false);
    }

    /**
     * 본인인증 내역 다건 조회 기능입니다.
     * 주어진 조건에 맞는 본인인증 내역들을 페이지 기반으로 조회합니다.
     */
    public function getIdentityVerifications(?array $page = null, ?array $sort = null, ?array $filter = null): Model\GetIdentityVerificationsResponse
    {
        return $this->callOperation('getIdentityVerifications', 'GET', '/identity-verifications', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetIdentityVerificationsResponse::class, true);
    }

    /**
     * 본인인증 내역 다건 조회 기능입니다.
     * 주어진 조건에 맞는 본인인증 내역들을 페이지 기반으로 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getIdentityVerificationsAsync(?array $page = null, ?array $sort = null, ?array $filter = null): Future
    {
        return $this->callOperationAsync('getIdentityVerifications', 'GET', '/identity-verifications', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetIdentityVerificationsResponse::class, true);
    }

    /**
     * SMS 본인인증 요청 재전송 기능입니다.
     * SMS 본인인증 요청을 재전송합니다.
     */
    public function resendIdentityVerification(?string $identityVerificationId = null, ?string $storeId = null): Model\ResendIdentityVerificationResponse
    {
        return $this->callOperation('resendIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/resend', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId], Model\ResendIdentityVerificationResponse::class, false);
    }

    /**
     * SMS 본인인증 요청 재전송 기능입니다.
     * SMS 본인인증 요청을 재전송합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function resendIdentityVerificationAsync(?string $identityVerificationId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('resendIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/resend', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId], Model\ResendIdentityVerificationResponse::class, false);
    }

    /**
     * 본인인증 요청 전송 기능입니다.
     * SMS 또는 APP 방식을 이용하여 본인인증 요청을 전송합니다.
     */
    public function sendIdentityVerification(?string $identityVerificationId = null, ?string $channelKey = null, ?array $customer = null, ?string $customData = null, ?array $bypass = null, ?string $operator = null, ?string $method = null, ?string $storeId = null): Model\SendIdentityVerificationResponse
    {
        return $this->callOperation('sendIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/send', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId, 'channelKey' => $channelKey, 'customer' => $customer, 'customData' => $customData, 'bypass' => $bypass, 'operator' => $operator, 'method' => $method], Model\SendIdentityVerificationResponse::class, true);
    }

    /**
     * 본인인증 요청 전송 기능입니다.
     * SMS 또는 APP 방식을 이용하여 본인인증 요청을 전송합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function sendIdentityVerificationAsync(?string $identityVerificationId = null, ?string $channelKey = null, ?array $customer = null, ?string $customData = null, ?array $bypass = null, ?string $operator = null, ?string $method = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('sendIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/send', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId, 'channelKey' => $channelKey, 'customer' => $customer, 'customData' => $customData, 'bypass' => $bypass, 'operator' => $operator, 'method' => $method], Model\SendIdentityVerificationResponse::class, true);
    }
}
