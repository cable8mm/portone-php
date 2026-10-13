<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 플랫폼 정책 API 작업을 제공합니다.
 */
final class PolicyClient extends AbstractClient
{
    /**
     * 추가 수수료 정책 보관 기능입니다.
     * 주어진 아이디에 대응되는 추가 수수료 정책을 보관합니다.
     */
    public function archivePlatformAdditionalFeePolicy(?string $id = null, ?bool $test = null): Model\ArchivePlatformAdditionalFeePolicyResponse
    {
        return $this->callOperation('archivePlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformAdditionalFeePolicyResponse::class, false);
    }

    /**
     * 추가 수수료 정책 보관 기능입니다.
     * 주어진 아이디에 대응되는 추가 수수료 정책을 보관합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function archivePlatformAdditionalFeePolicyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('archivePlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformAdditionalFeePolicyResponse::class, false);
    }

    /**
     * 계약 보관 기능입니다.
     * 주어진 아이디에 대응되는 계약을 보관합니다.
     */
    public function archivePlatformContract(?string $id = null, ?bool $test = null): Model\ArchivePlatformContractResponse
    {
        return $this->callOperation('archivePlatformContract', 'POST', '/platform/contracts/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformContractResponse::class, false);
    }

    /**
     * 계약 보관 기능입니다.
     * 주어진 아이디에 대응되는 계약을 보관합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function archivePlatformContractAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('archivePlatformContract', 'POST', '/platform/contracts/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformContractResponse::class, false);
    }

    /**
     * 할인 분담 정책 보관 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 보관합니다.
     */
    public function archivePlatformDiscountSharePolicy(?string $id = null, ?bool $test = null): Model\ArchivePlatformDiscountSharePolicyResponse
    {
        return $this->callOperation('archivePlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformDiscountSharePolicyResponse::class, false);
    }

    /**
     * 할인 분담 정책 보관 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 보관합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function archivePlatformDiscountSharePolicyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('archivePlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformDiscountSharePolicyResponse::class, false);
    }

    /**
     * 추가 수수료 정책 생성 기능입니다.
     * 새로운 추가 수수료 정책을 생성합니다.
     */
    public function createPlatformAdditionalFeePolicy(?bool $test = null, ?string $id = null, ?string $name = null, ?array $fee = null, ?string $memo = null, ?string $vatPayer = null): Model\CreatePlatformAdditionalFeePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies', ['test' => $test], ['id' => $id, 'name' => $name, 'fee' => $fee, 'memo' => $memo, 'vatPayer' => $vatPayer], Model\CreatePlatformAdditionalFeePolicyResponse::class);
    }

    /**
     * 추가 수수료 정책 생성 기능입니다.
     * 새로운 추가 수수료 정책을 생성합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function createPlatformAdditionalFeePolicyAsync(?bool $test = null, ?string $id = null, ?string $name = null, ?array $fee = null, ?string $memo = null, ?string $vatPayer = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies', ['test' => $test], ['id' => $id, 'name' => $name, 'fee' => $fee, 'memo' => $memo, 'vatPayer' => $vatPayer], Model\CreatePlatformAdditionalFeePolicyResponse::class);
    }

    /**
     * 계약 생성 기능입니다.
     * 새로운 계약을 생성합니다.
     */
    public function createPlatformContract(?bool $test = null, ?string $id = null, ?string $name = null, ?string $memo = null, ?array $platformFee = null, ?array $settlementCycle = null, ?string $platformFeeVatPayer = null, ?bool $subtractPaymentVatAmount = null): Model\CreatePlatformContractResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformContract', 'POST', '/platform/contracts', ['test' => $test], ['id' => $id, 'name' => $name, 'memo' => $memo, 'platformFee' => $platformFee, 'settlementCycle' => $settlementCycle, 'platformFeeVatPayer' => $platformFeeVatPayer, 'subtractPaymentVatAmount' => $subtractPaymentVatAmount], Model\CreatePlatformContractResponse::class);
    }

    /**
     * 계약 생성 기능입니다.
     * 새로운 계약을 생성합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function createPlatformContractAsync(?bool $test = null, ?string $id = null, ?string $name = null, ?string $memo = null, ?array $platformFee = null, ?array $settlementCycle = null, ?string $platformFeeVatPayer = null, ?bool $subtractPaymentVatAmount = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformContract', 'POST', '/platform/contracts', ['test' => $test], ['id' => $id, 'name' => $name, 'memo' => $memo, 'platformFee' => $platformFee, 'settlementCycle' => $settlementCycle, 'platformFeeVatPayer' => $platformFeeVatPayer, 'subtractPaymentVatAmount' => $subtractPaymentVatAmount], Model\CreatePlatformContractResponse::class);
    }

    /**
     * 할인 분담 정책 생성 기능입니다.
     * 새로운 할인 분담을 생성합니다.
     */
    public function createPlatformDiscountSharePolicy(?bool $test = null, ?string $id = null, ?string $name = null, ?int $partnerShareRate = null, ?string $memo = null): Model\CreatePlatformDiscountSharePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies', ['test' => $test], ['id' => $id, 'name' => $name, 'partnerShareRate' => $partnerShareRate, 'memo' => $memo], Model\CreatePlatformDiscountSharePolicyResponse::class);
    }

    /**
     * 할인 분담 정책 생성 기능입니다.
     * 새로운 할인 분담을 생성합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function createPlatformDiscountSharePolicyAsync(?bool $test = null, ?string $id = null, ?string $name = null, ?int $partnerShareRate = null, ?string $memo = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies', ['test' => $test], ['id' => $id, 'name' => $name, 'partnerShareRate' => $partnerShareRate, 'memo' => $memo], Model\CreatePlatformDiscountSharePolicyResponse::class);
    }

    /**
     * 추가 수수료 정책 다건 조회 기능입니다.
     * 여러 추가 수수료 정책을 조회합니다.
     */
    public function getPlatformAdditionalFeePolicies(?bool $test = null, ?array $page = null, ?array $filter = null): Model\GetPlatformAdditionalFeePoliciesResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformAdditionalFeePolicies', 'GET', '/platform/additional-fee-policies', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformAdditionalFeePoliciesResponse::class);
    }

    /**
     * 추가 수수료 정책 다건 조회 기능입니다.
     * 여러 추가 수수료 정책을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformAdditionalFeePoliciesAsync(?bool $test = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformAdditionalFeePolicies', 'GET', '/platform/additional-fee-policies', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformAdditionalFeePoliciesResponse::class);
    }

    /**
     * 추가 수수료 정책 조회 기능입니다.
     * 주어진 아이디에 대응되는 추가 수수료 정책을 조회합니다.
     */
    public function getPlatformAdditionalFeePolicy(?string $id = null, ?bool $test = null): Model\PlatformAdditionalFeePolicy
    {
        return $this->callOperation('getPlatformAdditionalFeePolicy', 'GET', '/platform/additional-fee-policies/{id}', ['id' => $id, 'test' => $test], Model\PlatformAdditionalFeePolicy::class, false);
    }

    /**
     * 추가 수수료 정책 조회 기능입니다.
     * 주어진 아이디에 대응되는 추가 수수료 정책을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformAdditionalFeePolicyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformAdditionalFeePolicy', 'GET', '/platform/additional-fee-policies/{id}', ['id' => $id, 'test' => $test], Model\PlatformAdditionalFeePolicy::class, false);
    }

    /**
     * 계약 조회 기능입니다.
     * 주어진 아이디에 대응되는 계약을 조회합니다.
     */
    public function getPlatformContract(?string $id = null, ?bool $test = null): Model\PlatformContract
    {
        return $this->callOperation('getPlatformContract', 'GET', '/platform/contracts/{id}', ['id' => $id, 'test' => $test], Model\PlatformContract::class, false);
    }

    /**
     * 계약 조회 기능입니다.
     * 주어진 아이디에 대응되는 계약을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformContractAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformContract', 'GET', '/platform/contracts/{id}', ['id' => $id, 'test' => $test], Model\PlatformContract::class, false);
    }

    /**
     * 계약 다건 조회 기능입니다.
     * 여러 계약을 조회합니다.
     */
    public function getPlatformContracts(?bool $test = null, ?array $page = null, ?array $filter = null): Model\GetPlatformContractsResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformContracts', 'GET', '/platform/contracts', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformContractsResponse::class);
    }

    /**
     * 계약 다건 조회 기능입니다.
     * 여러 계약을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformContractsAsync(?bool $test = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformContracts', 'GET', '/platform/contracts', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformContractsResponse::class);
    }

    /**
     * 할인 분담 정책 다건 조회 기능입니다.
     * 여러 할인 분담을 조회합니다.
     */
    public function getPlatformDiscountSharePolicies(?bool $test = null, ?array $page = null, ?array $filter = null): Model\GetPlatformDiscountSharePoliciesResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformDiscountSharePolicies', 'GET', '/platform/discount-share-policies', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformDiscountSharePoliciesResponse::class);
    }

    /**
     * 할인 분담 정책 다건 조회 기능입니다.
     * 여러 할인 분담을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformDiscountSharePoliciesAsync(?bool $test = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformDiscountSharePolicies', 'GET', '/platform/discount-share-policies', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformDiscountSharePoliciesResponse::class);
    }

    /**
     * 할인 분담 정책 조회 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 조회합니다.
     */
    public function getPlatformDiscountSharePolicy(?string $id = null, ?bool $test = null): Model\PlatformDiscountSharePolicy
    {
        return $this->callOperation('getPlatformDiscountSharePolicy', 'GET', '/platform/discount-share-policies/{id}', ['id' => $id, 'test' => $test], Model\PlatformDiscountSharePolicy::class, false);
    }

    /**
     * 할인 분담 정책 조회 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformDiscountSharePolicyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformDiscountSharePolicy', 'GET', '/platform/discount-share-policies/{id}', ['id' => $id, 'test' => $test], Model\PlatformDiscountSharePolicy::class, false);
    }

    /**
     * 추가 수수료 정책 복원 기능입니다.
     * 주어진 아이디에 대응되는 추가 수수료 정책을 복원합니다.
     */
    public function recoverPlatformAdditionalFeePolicy(?string $id = null, ?bool $test = null): Model\RecoverPlatformAdditionalFeePolicyResponse
    {
        return $this->callOperation('recoverPlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformAdditionalFeePolicyResponse::class, false);
    }

    /**
     * 추가 수수료 정책 복원 기능입니다.
     * 주어진 아이디에 대응되는 추가 수수료 정책을 복원합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function recoverPlatformAdditionalFeePolicyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('recoverPlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformAdditionalFeePolicyResponse::class, false);
    }

    /**
     * 계약 복원 기능입니다.
     * 주어진 아이디에 대응되는 계약을 복원합니다.
     */
    public function recoverPlatformContract(?string $id = null, ?bool $test = null): Model\RecoverPlatformContractResponse
    {
        return $this->callOperation('recoverPlatformContract', 'POST', '/platform/contracts/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformContractResponse::class, false);
    }

    /**
     * 계약 복원 기능입니다.
     * 주어진 아이디에 대응되는 계약을 복원합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function recoverPlatformContractAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('recoverPlatformContract', 'POST', '/platform/contracts/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformContractResponse::class, false);
    }

    /**
     * 할인 분담 정책 복원 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 복원합니다.
     */
    public function recoverPlatformDiscountSharePolicy(?string $id = null, ?bool $test = null): Model\RecoverPlatformDiscountSharePolicyResponse
    {
        return $this->callOperation('recoverPlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformDiscountSharePolicyResponse::class, false);
    }

    /**
     * 할인 분담 정책 복원 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 복원합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function recoverPlatformDiscountSharePolicyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('recoverPlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformDiscountSharePolicyResponse::class, false);
    }

    /**
     * 추가 수수료 정책 수정 기능입니다.
     * 주어진 아이디에 대응되는 추가 수수료 정책을 업데이트합니다.
     */
    public function updatePlatformAdditionalFeePolicy(?string $id = null, ?bool $test = null, ?array $fee = null, ?string $name = null, ?string $memo = null, ?string $vatPayer = null): Model\UpdatePlatformAdditionalFeePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformAdditionalFeePolicy', 'PATCH', '/platform/additional-fee-policies/{id}', ['id' => $id, 'test' => $test], ['fee' => $fee, 'name' => $name, 'memo' => $memo, 'vatPayer' => $vatPayer], Model\UpdatePlatformAdditionalFeePolicyResponse::class);
    }

    /**
     * 추가 수수료 정책 수정 기능입니다.
     * 주어진 아이디에 대응되는 추가 수수료 정책을 업데이트합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function updatePlatformAdditionalFeePolicyAsync(?string $id = null, ?bool $test = null, ?array $fee = null, ?string $name = null, ?string $memo = null, ?string $vatPayer = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformAdditionalFeePolicy', 'PATCH', '/platform/additional-fee-policies/{id}', ['id' => $id, 'test' => $test], ['fee' => $fee, 'name' => $name, 'memo' => $memo, 'vatPayer' => $vatPayer], Model\UpdatePlatformAdditionalFeePolicyResponse::class);
    }

    /**
     * 계약 수정 기능입니다.
     * 주어진 아이디에 대응되는 계약을 업데이트합니다.
     */
    public function updatePlatformContract(?string $id = null, ?bool $test = null, ?string $name = null, ?string $memo = null, ?array $platformFee = null, ?array $settlementCycle = null, ?string $platformFeeVatPayer = null, ?bool $subtractPaymentVatAmount = null): Model\UpdatePlatformContractResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformContract', 'PATCH', '/platform/contracts/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'memo' => $memo, 'platformFee' => $platformFee, 'settlementCycle' => $settlementCycle, 'platformFeeVatPayer' => $platformFeeVatPayer, 'subtractPaymentVatAmount' => $subtractPaymentVatAmount], Model\UpdatePlatformContractResponse::class);
    }

    /**
     * 계약 수정 기능입니다.
     * 주어진 아이디에 대응되는 계약을 업데이트합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function updatePlatformContractAsync(?string $id = null, ?bool $test = null, ?string $name = null, ?string $memo = null, ?array $platformFee = null, ?array $settlementCycle = null, ?string $platformFeeVatPayer = null, ?bool $subtractPaymentVatAmount = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformContract', 'PATCH', '/platform/contracts/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'memo' => $memo, 'platformFee' => $platformFee, 'settlementCycle' => $settlementCycle, 'platformFeeVatPayer' => $platformFeeVatPayer, 'subtractPaymentVatAmount' => $subtractPaymentVatAmount], Model\UpdatePlatformContractResponse::class);
    }

    /**
     * 할인 분담 정책 수정 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 업데이트합니다.
     */
    public function updatePlatformDiscountSharePolicy(?string $id = null, ?bool $test = null, ?string $name = null, ?int $partnerShareRate = null, ?string $memo = null): Model\UpdatePlatformDiscountSharePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformDiscountSharePolicy', 'PATCH', '/platform/discount-share-policies/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'partnerShareRate' => $partnerShareRate, 'memo' => $memo], Model\UpdatePlatformDiscountSharePolicyResponse::class);
    }

    /**
     * 할인 분담 정책 수정 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 업데이트합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function updatePlatformDiscountSharePolicyAsync(?string $id = null, ?bool $test = null, ?string $name = null, ?int $partnerShareRate = null, ?string $memo = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformDiscountSharePolicy', 'PATCH', '/platform/discount-share-policies/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'partnerShareRate' => $partnerShareRate, 'memo' => $memo], Model\UpdatePlatformDiscountSharePolicyResponse::class);
    }
}
