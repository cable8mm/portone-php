<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class IdentityVerificationClient extends AbstractClient
{
    public function confirmIdentityVerification(mixed $identityVerificationId = null, mixed $otp = null): Response\ConfirmIdentityVerificationResponse
    {
        return $this->callOperation('confirmIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/confirm', ['identityVerificationId' => $identityVerificationId, 'otp' => $otp], Response\ConfirmIdentityVerificationResponse::class, true);
    }

    public function confirmIdentityVerificationAsync(mixed $identityVerificationId = null, mixed $otp = null): Future
    {
        return $this->callOperationAsync('confirmIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/confirm', ['identityVerificationId' => $identityVerificationId, 'otp' => $otp], Response\ConfirmIdentityVerificationResponse::class, true);
    }

    public function getIdentityVerification(mixed $identityVerificationId = null): Response\IdentityVerification
    {
        return $this->callOperation('getIdentityVerification', 'GET', '/identity-verifications/{identityVerificationId}', ['identityVerificationId' => $identityVerificationId], Response\IdentityVerification::class, false);
    }

    public function getIdentityVerificationAsync(mixed $identityVerificationId = null): Future
    {
        return $this->callOperationAsync('getIdentityVerification', 'GET', '/identity-verifications/{identityVerificationId}', ['identityVerificationId' => $identityVerificationId], Response\IdentityVerification::class, false);
    }

    public function getIdentityVerifications(mixed $page = null, mixed $sort = null, mixed $filter = null): Response\GetIdentityVerificationsResponse
    {
        return $this->callOperation('getIdentityVerifications', 'GET', '/identity-verifications', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Response\GetIdentityVerificationsResponse::class, true);
    }

    public function getIdentityVerificationsAsync(mixed $page = null, mixed $sort = null, mixed $filter = null): Future
    {
        return $this->callOperationAsync('getIdentityVerifications', 'GET', '/identity-verifications', ['page' => $page, 'sort' => $sort, 'filter' => $filter], Response\GetIdentityVerificationsResponse::class, true);
    }

    public function resendIdentityVerification(mixed $identityVerificationId = null): Response\ResendIdentityVerificationResponse
    {
        return $this->callOperation('resendIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/resend', ['identityVerificationId' => $identityVerificationId], Response\ResendIdentityVerificationResponse::class, false);
    }

    public function resendIdentityVerificationAsync(mixed $identityVerificationId = null): Future
    {
        return $this->callOperationAsync('resendIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/resend', ['identityVerificationId' => $identityVerificationId], Response\ResendIdentityVerificationResponse::class, false);
    }

    public function sendIdentityVerification(mixed $identityVerificationId = null, mixed $channelKey = null, mixed $customer = null, mixed $customData = null, mixed $bypass = null, mixed $operator = null, mixed $method = null): Response\SendIdentityVerificationResponse
    {
        return $this->callOperation('sendIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/send', ['identityVerificationId' => $identityVerificationId, 'channelKey' => $channelKey, 'customer' => $customer, 'customData' => $customData, 'bypass' => $bypass, 'operator' => $operator, 'method' => $method], Response\SendIdentityVerificationResponse::class, true);
    }

    public function sendIdentityVerificationAsync(mixed $identityVerificationId = null, mixed $channelKey = null, mixed $customer = null, mixed $customData = null, mixed $bypass = null, mixed $operator = null, mixed $method = null): Future
    {
        return $this->callOperationAsync('sendIdentityVerification', 'POST', '/identity-verifications/{identityVerificationId}/send', ['identityVerificationId' => $identityVerificationId, 'channelKey' => $channelKey, 'customer' => $customer, 'customData' => $customData, 'bypass' => $bypass, 'operator' => $operator, 'method' => $method], Response\SendIdentityVerificationResponse::class, true);
    }
}
