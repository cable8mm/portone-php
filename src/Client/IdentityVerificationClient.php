<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

final class IdentityVerificationClient extends AbstractClient
{
    public function confirmIdentityVerification(?string $identityVerificationId = null, ?string $otp = null, ?string $storeId = null): Model\ConfirmIdentityVerificationResponse
    {
        return $this->callOperation('confirmIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/confirm', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId, 'otp' => $otp], Model\ConfirmIdentityVerificationResponse::class, true);
    }

    public function confirmIdentityVerificationAsync(?string $identityVerificationId = null, ?string $otp = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('confirmIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/confirm', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId, 'otp' => $otp], Model\ConfirmIdentityVerificationResponse::class, true);
    }

    public function getIdentityVerification(?string $identityVerificationId = null, ?string $storeId = null): Model\IdentityVerification
    {
        return $this->callOperation('getIdentityVerification', 'GET', '/identity-verifications/{identityVerificationId}', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId], Model\IdentityVerification::class, false);
    }

    public function getIdentityVerificationAsync(?string $identityVerificationId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('getIdentityVerification', 'GET', '/identity-verifications/{identityVerificationId}', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId], Model\IdentityVerification::class, false);
    }

    public function getIdentityVerifications(?array $page = null, ?array $sort = null, ?array $filter = null): Model\GetIdentityVerificationsResponse
    {
        return $this->callOperation('getIdentityVerifications', 'GET', '/identity-verifications', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetIdentityVerificationsResponse::class, true);
    }

    public function getIdentityVerificationsAsync(?array $page = null, ?array $sort = null, ?array $filter = null): Future
    {
        return $this->callOperationAsync('getIdentityVerifications', 'GET', '/identity-verifications', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Model\GetIdentityVerificationsResponse::class, true);
    }

    public function resendIdentityVerification(?string $identityVerificationId = null, ?string $storeId = null): Model\ResendIdentityVerificationResponse
    {
        return $this->callOperation('resendIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/resend', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId], Model\ResendIdentityVerificationResponse::class, false);
    }

    public function resendIdentityVerificationAsync(?string $identityVerificationId = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('resendIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/resend', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId], Model\ResendIdentityVerificationResponse::class, false);
    }

    public function sendIdentityVerification(?string $identityVerificationId = null, ?string $channelKey = null, ?array $customer = null, ?string $customData = null, ?array $bypass = null, ?string $operator = null, ?string $method = null, ?string $storeId = null): Model\SendIdentityVerificationResponse
    {
        return $this->callOperation('sendIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/send', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId, 'channelKey' => $channelKey, 'customer' => $customer, 'customData' => $customData, 'bypass' => $bypass, 'operator' => $operator, 'method' => $method], Model\SendIdentityVerificationResponse::class, true);
    }

    public function sendIdentityVerificationAsync(?string $identityVerificationId = null, ?string $channelKey = null, ?array $customer = null, ?string $customData = null, ?array $bypass = null, ?string $operator = null, ?string $method = null, ?string $storeId = null): Future
    {
        return $this->callOperationAsync('sendIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/send', ['storeId' => $storeId, 'identityVerificationId' => $identityVerificationId, 'channelKey' => $channelKey, 'customer' => $customer, 'customData' => $customData, 'bypass' => $bypass, 'operator' => $operator, 'method' => $method], Model\SendIdentityVerificationResponse::class, true);
    }
}
