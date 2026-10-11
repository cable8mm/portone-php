<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

use Cable8mm\PortonePhp\Http\RequestExecutor;

final class PlatformClient extends AbstractClient
{
    public readonly CompanyClient $company;

    public readonly AccountTransferClient $accountTransfer;

    public readonly PolicyClient $policy;

    public readonly AccountClient $account;

    public readonly BulkAccountTransferClient $bulkAccountTransfer;

    public readonly BulkPayoutClient $bulkPayout;

    public readonly PayoutClient $payout;

    public readonly PartnerSettlementClient $partnerSettlement;

    public readonly PartnerClient $partner;

    public readonly TransferClient $transfer;

    public function __construct(string $apiSecret, ?RequestExecutor $executor = null)
    {
        parent::__construct($apiSecret, $executor);
        $this->company = new CompanyClient('', $this->executor);
        $this->accountTransfer = new AccountTransferClient('', $this->executor);
        $this->policy = new PolicyClient('', $this->executor);
        $this->account = new AccountClient('', $this->executor);
        $this->bulkAccountTransfer = new BulkAccountTransferClient('', $this->executor);
        $this->bulkPayout = new BulkPayoutClient('', $this->executor);
        $this->payout = new PayoutClient('', $this->executor);
        $this->partnerSettlement = new PartnerSettlementClient('', $this->executor);
        $this->partner = new PartnerClient('', $this->executor);
        $this->transfer = new TransferClient('', $this->executor);
    }

    public function cancelPlatformAdditionalFeePolicySchedule(?string $id = null, ?bool $test = null): Response\CancelPlatformAdditionalFeePolicyScheduleResponse
    {
        return $this->callOperation('cancelPlatformAdditionalFeePolicySchedule', 'DELETE', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], Response\CancelPlatformAdditionalFeePolicyScheduleResponse::class, false);
    }

    public function cancelPlatformAdditionalFeePolicyScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('cancelPlatformAdditionalFeePolicySchedule', 'DELETE', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], Response\CancelPlatformAdditionalFeePolicyScheduleResponse::class, false);
    }

    public function cancelPlatformContractSchedule(?string $id = null, ?bool $test = null): Response\CancelPlatformContractScheduleResponse
    {
        return $this->callOperation('cancelPlatformContractSchedule', 'DELETE', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], Response\CancelPlatformContractScheduleResponse::class, false);
    }

    public function cancelPlatformContractScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('cancelPlatformContractSchedule', 'DELETE', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], Response\CancelPlatformContractScheduleResponse::class, false);
    }

    public function cancelPlatformDiscountSharePolicySchedule(?string $id = null, ?bool $test = null): Response\CancelPlatformDiscountSharePolicyScheduleResponse
    {
        return $this->callOperation('cancelPlatformDiscountSharePolicySchedule', 'DELETE', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], Response\CancelPlatformDiscountSharePolicyScheduleResponse::class, false);
    }

    public function cancelPlatformDiscountSharePolicyScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('cancelPlatformDiscountSharePolicySchedule', 'DELETE', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], Response\CancelPlatformDiscountSharePolicyScheduleResponse::class, false);
    }

    public function cancelPlatformPartnerSchedule(?string $id = null, ?bool $test = null): Response\CancelPlatformPartnerScheduleResponse
    {
        return $this->callOperation('cancelPlatformPartnerSchedule', 'DELETE', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], Response\CancelPlatformPartnerScheduleResponse::class, false);
    }

    public function cancelPlatformPartnerScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('cancelPlatformPartnerSchedule', 'DELETE', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], Response\CancelPlatformPartnerScheduleResponse::class, false);
    }

    public function getPlatformAdditionalFeePolicySchedule(?string $id = null, ?bool $test = null): Response\PlatformAdditionalFeePolicy
    {
        return $this->callOperation('getPlatformAdditionalFeePolicySchedule', 'GET', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], Response\PlatformAdditionalFeePolicy::class, false);
    }

    public function getPlatformAdditionalFeePolicyScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformAdditionalFeePolicySchedule', 'GET', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], Response\PlatformAdditionalFeePolicy::class, false);
    }

    public function getPlatformContractSchedule(?string $id = null, ?bool $test = null): Response\PlatformContract
    {
        return $this->callOperation('getPlatformContractSchedule', 'GET', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], Response\PlatformContract::class, false);
    }

    public function getPlatformContractScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformContractSchedule', 'GET', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], Response\PlatformContract::class, false);
    }

    public function getPlatformDiscountSharePolicyFilterOptions(?bool $test = null, ?bool $isArchived = null): Response\PlatformDiscountSharePolicyFilterOptions
    {
        return $this->callOperation('getPlatformDiscountSharePolicyFilterOptions', 'GET', '/platform/discount-share-policy-filter-options', ['test' => $test, 'isArchived' => $isArchived], Response\PlatformDiscountSharePolicyFilterOptions::class, false);
    }

    public function getPlatformDiscountSharePolicyFilterOptionsAsync(?bool $test = null, ?bool $isArchived = null): Future
    {
        return $this->callOperationAsync('getPlatformDiscountSharePolicyFilterOptions', 'GET', '/platform/discount-share-policy-filter-options', ['test' => $test, 'isArchived' => $isArchived], Response\PlatformDiscountSharePolicyFilterOptions::class, false);
    }

    public function getPlatformDiscountSharePolicySchedule(?string $id = null, ?bool $test = null): Response\PlatformDiscountSharePolicy
    {
        return $this->callOperation('getPlatformDiscountSharePolicySchedule', 'GET', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], Response\PlatformDiscountSharePolicy::class, false);
    }

    public function getPlatformDiscountSharePolicyScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformDiscountSharePolicySchedule', 'GET', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], Response\PlatformDiscountSharePolicy::class, false);
    }

    public function getPlatformPartnerFilterOptions(?bool $test = null, ?bool $isArchived = null): Response\PlatformPartnerFilterOptions
    {
        return $this->callOperation('getPlatformPartnerFilterOptions', 'GET', '/platform/partner-filter-options', ['test' => $test, 'isArchived' => $isArchived], Response\PlatformPartnerFilterOptions::class, false);
    }

    public function getPlatformPartnerFilterOptionsAsync(?bool $test = null, ?bool $isArchived = null): Future
    {
        return $this->callOperationAsync('getPlatformPartnerFilterOptions', 'GET', '/platform/partner-filter-options', ['test' => $test, 'isArchived' => $isArchived], Response\PlatformPartnerFilterOptions::class, false);
    }

    public function getPlatformPartnerSchedule(?string $id = null, ?bool $test = null): Response\PlatformPartner
    {
        return $this->callOperation('getPlatformPartnerSchedule', 'GET', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], Response\PlatformPartner::class, false);
    }

    public function getPlatformPartnerScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformPartnerSchedule', 'GET', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], Response\PlatformPartner::class, false);
    }

    public function getPlatformSetting(?bool $test = null): Response\PlatformSetting
    {
        return $this->callOperation('getPlatformSetting', 'GET', '/platform/setting', ['test' => $test], Response\PlatformSetting::class, false);
    }

    public function getPlatformSettingAsync(?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformSetting', 'GET', '/platform/setting', ['test' => $test], Response\PlatformSetting::class, false);
    }

    public function rescheduleAdditionalFeePolicy(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Response\ReschedulePlatformAdditionalFeePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('rescheduleAdditionalFeePolicy', 'PUT', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\ReschedulePlatformAdditionalFeePolicyResponse::class);
    }

    public function rescheduleAdditionalFeePolicyAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('rescheduleAdditionalFeePolicy', 'PUT', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\ReschedulePlatformAdditionalFeePolicyResponse::class);
    }

    public function rescheduleContract(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Response\ReschedulePlatformContractResponse
    {
        return $this->callOperationWithQueryAndBody('rescheduleContract', 'PUT', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\ReschedulePlatformContractResponse::class);
    }

    public function rescheduleContractAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('rescheduleContract', 'PUT', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\ReschedulePlatformContractResponse::class);
    }

    public function rescheduleDiscountSharePolicy(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Response\ReschedulePlatformDiscountSharePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('rescheduleDiscountSharePolicy', 'PUT', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\ReschedulePlatformDiscountSharePolicyResponse::class);
    }

    public function rescheduleDiscountSharePolicyAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('rescheduleDiscountSharePolicy', 'PUT', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\ReschedulePlatformDiscountSharePolicyResponse::class);
    }

    public function reschedulePartner(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Response\ReschedulePlatformPartnerResponse
    {
        return $this->callOperationWithQueryAndBody('reschedulePartner', 'PUT', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\ReschedulePlatformPartnerResponse::class);
    }

    public function reschedulePartnerAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('reschedulePartner', 'PUT', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\ReschedulePlatformPartnerResponse::class);
    }

    public function scheduleAdditionalFeePolicy(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Response\SchedulePlatformAdditionalFeePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('scheduleAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\SchedulePlatformAdditionalFeePolicyResponse::class);
    }

    public function scheduleAdditionalFeePolicyAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('scheduleAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\SchedulePlatformAdditionalFeePolicyResponse::class);
    }

    public function scheduleContract(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Response\SchedulePlatformContractResponse
    {
        return $this->callOperationWithQueryAndBody('scheduleContract', 'POST', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\SchedulePlatformContractResponse::class);
    }

    public function scheduleContractAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('scheduleContract', 'POST', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\SchedulePlatformContractResponse::class);
    }

    public function scheduleDiscountSharePolicy(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Response\SchedulePlatformDiscountSharePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('scheduleDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\SchedulePlatformDiscountSharePolicyResponse::class);
    }

    public function scheduleDiscountSharePolicyAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('scheduleDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\SchedulePlatformDiscountSharePolicyResponse::class);
    }

    public function schedulePartner(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Response\SchedulePlatformPartnerResponse
    {
        return $this->callOperationWithQueryAndBody('schedulePartner', 'POST', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\SchedulePlatformPartnerResponse::class);
    }

    public function schedulePartnerAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('schedulePartner', 'POST', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Response\SchedulePlatformPartnerResponse::class);
    }

    public function schedulePlatformPartners(?bool $test = null, ?array $filter = null, ?array $update = null, ?string $appliedAt = null): Response\SchedulePlatformPartnersResponse
    {
        return $this->callOperationWithQueryAndBody('schedulePlatformPartners', 'POST', '/platform/partners/schedule', ['test' => $test], ['filter' => $filter, 'update' => $update, 'appliedAt' => $appliedAt], Response\SchedulePlatformPartnersResponse::class);
    }

    public function schedulePlatformPartnersAsync(?bool $test = null, ?array $filter = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('schedulePlatformPartners', 'POST', '/platform/partners/schedule', ['test' => $test], ['filter' => $filter, 'update' => $update, 'appliedAt' => $appliedAt], Response\SchedulePlatformPartnersResponse::class);
    }

    public function updatePlatformSetting(?bool $test = null, ?string $defaultWithdrawalMemo = null, ?string $defaultDepositMemo = null, ?bool $supportsMultipleOrderTransfersPerPartner = null, ?bool $adjustSettlementDateAfterHolidayIfEarlier = null, ?bool $deductWht = null, ?string $settlementAmountType = null, ?bool $manualSettlementPerTransfer = null): Response\UpdatePlatformSettingResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformSetting', 'PATCH', '/platform/setting', ['test' => $test], ['manualSettlementPerTransfer' => $manualSettlementPerTransfer, 'defaultWithdrawalMemo' => $defaultWithdrawalMemo, 'defaultDepositMemo' => $defaultDepositMemo, 'supportsMultipleOrderTransfersPerPartner' => $supportsMultipleOrderTransfersPerPartner, 'adjustSettlementDateAfterHolidayIfEarlier' => $adjustSettlementDateAfterHolidayIfEarlier, 'deductWht' => $deductWht, 'settlementAmountType' => $settlementAmountType], Response\UpdatePlatformSettingResponse::class);
    }

    public function updatePlatformSettingAsync(?bool $test = null, ?string $defaultWithdrawalMemo = null, ?string $defaultDepositMemo = null, ?bool $supportsMultipleOrderTransfersPerPartner = null, ?bool $adjustSettlementDateAfterHolidayIfEarlier = null, ?bool $deductWht = null, ?string $settlementAmountType = null, ?bool $manualSettlementPerTransfer = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformSetting', 'PATCH', '/platform/setting', ['test' => $test], ['manualSettlementPerTransfer' => $manualSettlementPerTransfer, 'defaultWithdrawalMemo' => $defaultWithdrawalMemo, 'defaultDepositMemo' => $defaultDepositMemo, 'supportsMultipleOrderTransfersPerPartner' => $supportsMultipleOrderTransfersPerPartner, 'adjustSettlementDateAfterHolidayIfEarlier' => $adjustSettlementDateAfterHolidayIfEarlier, 'deductWht' => $deductWht, 'settlementAmountType' => $settlementAmountType], Response\UpdatePlatformSettingResponse::class);
    }
}
