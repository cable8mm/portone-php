<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class PolicyClient extends AbstractClient
{
    public function archivePlatformAdditionalFeePolicy(mixed $id = null, mixed $test = null): Response\ArchivePlatformAdditionalFeePolicyResponse
    {
        return $this->callOperation('archivePlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/archive', ['id' => $id, 'test' => $test], Response\ArchivePlatformAdditionalFeePolicyResponse::class, false);
    }

    public function archivePlatformAdditionalFeePolicyAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('archivePlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/archive', ['id' => $id, 'test' => $test], Response\ArchivePlatformAdditionalFeePolicyResponse::class, false);
    }

    public function archivePlatformContract(mixed $id = null, mixed $test = null): Response\ArchivePlatformContractResponse
    {
        return $this->callOperation('archivePlatformContract', 'POST', '/platform/contracts/{id}/archive', ['id' => $id, 'test' => $test], Response\ArchivePlatformContractResponse::class, false);
    }

    public function archivePlatformContractAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('archivePlatformContract', 'POST', '/platform/contracts/{id}/archive', ['id' => $id, 'test' => $test], Response\ArchivePlatformContractResponse::class, false);
    }

    public function archivePlatformDiscountSharePolicy(mixed $id = null, mixed $test = null): Response\ArchivePlatformDiscountSharePolicyResponse
    {
        return $this->callOperation('archivePlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/archive', ['id' => $id, 'test' => $test], Response\ArchivePlatformDiscountSharePolicyResponse::class, false);
    }

    public function archivePlatformDiscountSharePolicyAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('archivePlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/archive', ['id' => $id, 'test' => $test], Response\ArchivePlatformDiscountSharePolicyResponse::class, false);
    }

    public function createPlatformAdditionalFeePolicy(mixed $test = null, mixed $id = null, mixed $name = null, mixed $fee = null, mixed $memo = null, mixed $vatPayer = null): Response\CreatePlatformAdditionalFeePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies', ['test' => $test], ['id' => $id, 'name' => $name, 'fee' => $fee, 'memo' => $memo, 'vatPayer' => $vatPayer], Response\CreatePlatformAdditionalFeePolicyResponse::class);
    }

    public function createPlatformAdditionalFeePolicyAsync(mixed $test = null, mixed $id = null, mixed $name = null, mixed $fee = null, mixed $memo = null, mixed $vatPayer = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies', ['test' => $test], ['id' => $id, 'name' => $name, 'fee' => $fee, 'memo' => $memo, 'vatPayer' => $vatPayer], Response\CreatePlatformAdditionalFeePolicyResponse::class);
    }

    public function createPlatformContract(mixed $test = null, mixed $id = null, mixed $name = null, mixed $memo = null, mixed $platformFee = null, mixed $settlementCycle = null, mixed $platformFeeVatPayer = null, mixed $subtractPaymentVatAmount = null): Response\CreatePlatformContractResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformContract', 'POST', '/platform/contracts', ['test' => $test], ['id' => $id, 'name' => $name, 'memo' => $memo, 'platformFee' => $platformFee, 'settlementCycle' => $settlementCycle, 'platformFeeVatPayer' => $platformFeeVatPayer, 'subtractPaymentVatAmount' => $subtractPaymentVatAmount], Response\CreatePlatformContractResponse::class);
    }

    public function createPlatformContractAsync(mixed $test = null, mixed $id = null, mixed $name = null, mixed $memo = null, mixed $platformFee = null, mixed $settlementCycle = null, mixed $platformFeeVatPayer = null, mixed $subtractPaymentVatAmount = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformContract', 'POST', '/platform/contracts', ['test' => $test], ['id' => $id, 'name' => $name, 'memo' => $memo, 'platformFee' => $platformFee, 'settlementCycle' => $settlementCycle, 'platformFeeVatPayer' => $platformFeeVatPayer, 'subtractPaymentVatAmount' => $subtractPaymentVatAmount], Response\CreatePlatformContractResponse::class);
    }

    public function createPlatformDiscountSharePolicy(mixed $test = null, mixed $id = null, mixed $name = null, mixed $partnerShareRate = null, mixed $memo = null): Response\CreatePlatformDiscountSharePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies', ['test' => $test], ['id' => $id, 'name' => $name, 'partnerShareRate' => $partnerShareRate, 'memo' => $memo], Response\CreatePlatformDiscountSharePolicyResponse::class);
    }

    public function createPlatformDiscountSharePolicyAsync(mixed $test = null, mixed $id = null, mixed $name = null, mixed $partnerShareRate = null, mixed $memo = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies', ['test' => $test], ['id' => $id, 'name' => $name, 'partnerShareRate' => $partnerShareRate, 'memo' => $memo], Response\CreatePlatformDiscountSharePolicyResponse::class);
    }

    public function getPlatformAdditionalFeePolicies(mixed $test = null, mixed $page = null, mixed $filter = null): Response\GetPlatformAdditionalFeePoliciesResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformAdditionalFeePolicies', 'GET', '/platform/additional-fee-policies', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetPlatformAdditionalFeePoliciesResponse::class);
    }

    public function getPlatformAdditionalFeePoliciesAsync(mixed $test = null, mixed $page = null, mixed $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformAdditionalFeePolicies', 'GET', '/platform/additional-fee-policies', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetPlatformAdditionalFeePoliciesResponse::class);
    }

    public function getPlatformAdditionalFeePolicy(mixed $id = null, mixed $test = null): Response\PlatformAdditionalFeePolicy
    {
        return $this->callOperation('getPlatformAdditionalFeePolicy', 'GET', '/platform/additional-fee-policies/{id}', ['id' => $id, 'test' => $test], Response\PlatformAdditionalFeePolicy::class, false);
    }

    public function getPlatformAdditionalFeePolicyAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('getPlatformAdditionalFeePolicy', 'GET', '/platform/additional-fee-policies/{id}', ['id' => $id, 'test' => $test], Response\PlatformAdditionalFeePolicy::class, false);
    }

    public function getPlatformContract(mixed $id = null, mixed $test = null): Response\PlatformContract
    {
        return $this->callOperation('getPlatformContract', 'GET', '/platform/contracts/{id}', ['id' => $id, 'test' => $test], Response\PlatformContract::class, false);
    }

    public function getPlatformContractAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('getPlatformContract', 'GET', '/platform/contracts/{id}', ['id' => $id, 'test' => $test], Response\PlatformContract::class, false);
    }

    public function getPlatformContracts(mixed $test = null, mixed $page = null, mixed $filter = null): Response\GetPlatformContractsResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformContracts', 'GET', '/platform/contracts', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetPlatformContractsResponse::class);
    }

    public function getPlatformContractsAsync(mixed $test = null, mixed $page = null, mixed $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformContracts', 'GET', '/platform/contracts', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetPlatformContractsResponse::class);
    }

    public function getPlatformDiscountSharePolicies(mixed $test = null, mixed $page = null, mixed $filter = null): Response\GetPlatformDiscountSharePoliciesResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformDiscountSharePolicies', 'GET', '/platform/discount-share-policies', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetPlatformDiscountSharePoliciesResponse::class);
    }

    public function getPlatformDiscountSharePoliciesAsync(mixed $test = null, mixed $page = null, mixed $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformDiscountSharePolicies', 'GET', '/platform/discount-share-policies', ['test' => $test], ['page' => $page, 'filter' => $filter], Response\GetPlatformDiscountSharePoliciesResponse::class);
    }

    public function getPlatformDiscountSharePolicy(mixed $id = null, mixed $test = null): Response\PlatformDiscountSharePolicy
    {
        return $this->callOperation('getPlatformDiscountSharePolicy', 'GET', '/platform/discount-share-policies/{id}', ['id' => $id, 'test' => $test], Response\PlatformDiscountSharePolicy::class, false);
    }

    public function getPlatformDiscountSharePolicyAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('getPlatformDiscountSharePolicy', 'GET', '/platform/discount-share-policies/{id}', ['id' => $id, 'test' => $test], Response\PlatformDiscountSharePolicy::class, false);
    }

    public function recoverPlatformAdditionalFeePolicy(mixed $id = null, mixed $test = null): Response\RecoverPlatformAdditionalFeePolicyResponse
    {
        return $this->callOperation('recoverPlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/recover', ['id' => $id, 'test' => $test], Response\RecoverPlatformAdditionalFeePolicyResponse::class, false);
    }

    public function recoverPlatformAdditionalFeePolicyAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('recoverPlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/recover', ['id' => $id, 'test' => $test], Response\RecoverPlatformAdditionalFeePolicyResponse::class, false);
    }

    public function recoverPlatformContract(mixed $id = null, mixed $test = null): Response\RecoverPlatformContractResponse
    {
        return $this->callOperation('recoverPlatformContract', 'POST', '/platform/contracts/{id}/recover', ['id' => $id, 'test' => $test], Response\RecoverPlatformContractResponse::class, false);
    }

    public function recoverPlatformContractAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('recoverPlatformContract', 'POST', '/platform/contracts/{id}/recover', ['id' => $id, 'test' => $test], Response\RecoverPlatformContractResponse::class, false);
    }

    public function recoverPlatformDiscountSharePolicy(mixed $id = null, mixed $test = null): Response\RecoverPlatformDiscountSharePolicyResponse
    {
        return $this->callOperation('recoverPlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/recover', ['id' => $id, 'test' => $test], Response\RecoverPlatformDiscountSharePolicyResponse::class, false);
    }

    public function recoverPlatformDiscountSharePolicyAsync(mixed $id = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('recoverPlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/recover', ['id' => $id, 'test' => $test], Response\RecoverPlatformDiscountSharePolicyResponse::class, false);
    }

    public function updatePlatformAdditionalFeePolicy(mixed $id = null, mixed $test = null, mixed $fee = null, mixed $name = null, mixed $memo = null, mixed $vatPayer = null): Response\UpdatePlatformAdditionalFeePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformAdditionalFeePolicy', 'PATCH', '/platform/additional-fee-policies/{id}', ['id' => $id, 'test' => $test], ['fee' => $fee, 'name' => $name, 'memo' => $memo, 'vatPayer' => $vatPayer], Response\UpdatePlatformAdditionalFeePolicyResponse::class);
    }

    public function updatePlatformAdditionalFeePolicyAsync(mixed $id = null, mixed $test = null, mixed $fee = null, mixed $name = null, mixed $memo = null, mixed $vatPayer = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformAdditionalFeePolicy', 'PATCH', '/platform/additional-fee-policies/{id}', ['id' => $id, 'test' => $test], ['fee' => $fee, 'name' => $name, 'memo' => $memo, 'vatPayer' => $vatPayer], Response\UpdatePlatformAdditionalFeePolicyResponse::class);
    }

    public function updatePlatformContract(mixed $id = null, mixed $test = null, mixed $name = null, mixed $memo = null, mixed $platformFee = null, mixed $settlementCycle = null, mixed $platformFeeVatPayer = null, mixed $subtractPaymentVatAmount = null): Response\UpdatePlatformContractResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformContract', 'PATCH', '/platform/contracts/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'memo' => $memo, 'platformFee' => $platformFee, 'settlementCycle' => $settlementCycle, 'platformFeeVatPayer' => $platformFeeVatPayer, 'subtractPaymentVatAmount' => $subtractPaymentVatAmount], Response\UpdatePlatformContractResponse::class);
    }

    public function updatePlatformContractAsync(mixed $id = null, mixed $test = null, mixed $name = null, mixed $memo = null, mixed $platformFee = null, mixed $settlementCycle = null, mixed $platformFeeVatPayer = null, mixed $subtractPaymentVatAmount = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformContract', 'PATCH', '/platform/contracts/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'memo' => $memo, 'platformFee' => $platformFee, 'settlementCycle' => $settlementCycle, 'platformFeeVatPayer' => $platformFeeVatPayer, 'subtractPaymentVatAmount' => $subtractPaymentVatAmount], Response\UpdatePlatformContractResponse::class);
    }

    public function updatePlatformDiscountSharePolicy(mixed $id = null, mixed $test = null, mixed $name = null, mixed $partnerShareRate = null, mixed $memo = null): Response\UpdatePlatformDiscountSharePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformDiscountSharePolicy', 'PATCH', '/platform/discount-share-policies/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'partnerShareRate' => $partnerShareRate, 'memo' => $memo], Response\UpdatePlatformDiscountSharePolicyResponse::class);
    }

    public function updatePlatformDiscountSharePolicyAsync(mixed $id = null, mixed $test = null, mixed $name = null, mixed $partnerShareRate = null, mixed $memo = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformDiscountSharePolicy', 'PATCH', '/platform/discount-share-policies/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'partnerShareRate' => $partnerShareRate, 'memo' => $memo], Response\UpdatePlatformDiscountSharePolicyResponse::class);
    }
}
