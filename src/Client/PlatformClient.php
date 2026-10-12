<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\Model;

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

    public function __construct(#[\SensitiveParameter] string $apiSecret, ?RequestExecutor $executor = null)
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

    public function cancelPlatformAdditionalFeePolicySchedule(?string $id = null, ?bool $test = null): Model\CancelPlatformAdditionalFeePolicyScheduleResponse
    {
        return $this->callOperation('cancelPlatformAdditionalFeePolicySchedule', 'DELETE', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformAdditionalFeePolicyScheduleResponse::class, false);
    }

    public function cancelPlatformAdditionalFeePolicyScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('cancelPlatformAdditionalFeePolicySchedule', 'DELETE', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformAdditionalFeePolicyScheduleResponse::class, false);
    }

    public function cancelPlatformContractSchedule(?string $id = null, ?bool $test = null): Model\CancelPlatformContractScheduleResponse
    {
        return $this->callOperation('cancelPlatformContractSchedule', 'DELETE', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformContractScheduleResponse::class, false);
    }

    public function cancelPlatformContractScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('cancelPlatformContractSchedule', 'DELETE', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformContractScheduleResponse::class, false);
    }

    public function cancelPlatformDiscountSharePolicySchedule(?string $id = null, ?bool $test = null): Model\CancelPlatformDiscountSharePolicyScheduleResponse
    {
        return $this->callOperation('cancelPlatformDiscountSharePolicySchedule', 'DELETE', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformDiscountSharePolicyScheduleResponse::class, false);
    }

    public function cancelPlatformDiscountSharePolicyScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('cancelPlatformDiscountSharePolicySchedule', 'DELETE', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformDiscountSharePolicyScheduleResponse::class, false);
    }

    public function cancelPlatformPartnerSchedule(?string $id = null, ?bool $test = null): Model\CancelPlatformPartnerScheduleResponse
    {
        return $this->callOperation('cancelPlatformPartnerSchedule', 'DELETE', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformPartnerScheduleResponse::class, false);
    }

    public function cancelPlatformPartnerScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('cancelPlatformPartnerSchedule', 'DELETE', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformPartnerScheduleResponse::class, false);
    }

    public function getPlatformAdditionalFeePolicySchedule(?string $id = null, ?bool $test = null): Model\PlatformAdditionalFeePolicy
    {
        return $this->callOperation('getPlatformAdditionalFeePolicySchedule', 'GET', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformAdditionalFeePolicy::class, false);
    }

    public function getPlatformAdditionalFeePolicyScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformAdditionalFeePolicySchedule', 'GET', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformAdditionalFeePolicy::class, false);
    }

    public function getPlatformContractSchedule(?string $id = null, ?bool $test = null): Model\PlatformContract
    {
        return $this->callOperation('getPlatformContractSchedule', 'GET', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformContract::class, false);
    }

    public function getPlatformContractScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformContractSchedule', 'GET', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformContract::class, false);
    }

    public function getPlatformDiscountSharePolicyFilterOptions(?bool $test = null, ?bool $isArchived = null): Model\PlatformDiscountSharePolicyFilterOptions
    {
        return $this->callOperation('getPlatformDiscountSharePolicyFilterOptions', 'GET', '/platform/discount-share-policy-filter-options', ['test' => $test, 'isArchived' => $isArchived], Model\PlatformDiscountSharePolicyFilterOptions::class, false);
    }

    public function getPlatformDiscountSharePolicyFilterOptionsAsync(?bool $test = null, ?bool $isArchived = null): Future
    {
        return $this->callOperationAsync('getPlatformDiscountSharePolicyFilterOptions', 'GET', '/platform/discount-share-policy-filter-options', ['test' => $test, 'isArchived' => $isArchived], Model\PlatformDiscountSharePolicyFilterOptions::class, false);
    }

    public function getPlatformDiscountSharePolicySchedule(?string $id = null, ?bool $test = null): Model\PlatformDiscountSharePolicy
    {
        return $this->callOperation('getPlatformDiscountSharePolicySchedule', 'GET', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformDiscountSharePolicy::class, false);
    }

    public function getPlatformDiscountSharePolicyScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformDiscountSharePolicySchedule', 'GET', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformDiscountSharePolicy::class, false);
    }

    public function getPlatformPartnerFilterOptions(?bool $test = null, ?bool $isArchived = null): Model\PlatformPartnerFilterOptions
    {
        return $this->callOperation('getPlatformPartnerFilterOptions', 'GET', '/platform/partner-filter-options', ['test' => $test, 'isArchived' => $isArchived], Model\PlatformPartnerFilterOptions::class, false);
    }

    public function getPlatformPartnerFilterOptionsAsync(?bool $test = null, ?bool $isArchived = null): Future
    {
        return $this->callOperationAsync('getPlatformPartnerFilterOptions', 'GET', '/platform/partner-filter-options', ['test' => $test, 'isArchived' => $isArchived], Model\PlatformPartnerFilterOptions::class, false);
    }

    public function getPlatformPartnerSchedule(?string $id = null, ?bool $test = null): Model\PlatformPartner
    {
        return $this->callOperation('getPlatformPartnerSchedule', 'GET', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformPartner::class, false);
    }

    public function getPlatformPartnerScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformPartnerSchedule', 'GET', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformPartner::class, false);
    }

    public function getPlatformSetting(?bool $test = null): Model\PlatformSetting
    {
        return $this->callOperation('getPlatformSetting', 'GET', '/platform/setting', ['test' => $test], Model\PlatformSetting::class, false);
    }

    public function getPlatformSettingAsync(?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformSetting', 'GET', '/platform/setting', ['test' => $test], Model\PlatformSetting::class, false);
    }

    public function rescheduleAdditionalFeePolicy(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\ReschedulePlatformAdditionalFeePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('rescheduleAdditionalFeePolicy', 'PUT', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformAdditionalFeePolicyResponse::class);
    }

    public function rescheduleAdditionalFeePolicyAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('rescheduleAdditionalFeePolicy', 'PUT', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformAdditionalFeePolicyResponse::class);
    }

    public function rescheduleContract(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\ReschedulePlatformContractResponse
    {
        return $this->callOperationWithQueryAndBody('rescheduleContract', 'PUT', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformContractResponse::class);
    }

    public function rescheduleContractAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('rescheduleContract', 'PUT', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformContractResponse::class);
    }

    public function rescheduleDiscountSharePolicy(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\ReschedulePlatformDiscountSharePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('rescheduleDiscountSharePolicy', 'PUT', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformDiscountSharePolicyResponse::class);
    }

    public function rescheduleDiscountSharePolicyAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('rescheduleDiscountSharePolicy', 'PUT', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformDiscountSharePolicyResponse::class);
    }

    public function reschedulePartner(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\ReschedulePlatformPartnerResponse
    {
        return $this->callOperationWithQueryAndBody('reschedulePartner', 'PUT', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformPartnerResponse::class);
    }

    public function reschedulePartnerAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('reschedulePartner', 'PUT', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformPartnerResponse::class);
    }

    public function scheduleAdditionalFeePolicy(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\SchedulePlatformAdditionalFeePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('scheduleAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformAdditionalFeePolicyResponse::class);
    }

    public function scheduleAdditionalFeePolicyAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('scheduleAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformAdditionalFeePolicyResponse::class);
    }

    public function scheduleContract(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\SchedulePlatformContractResponse
    {
        return $this->callOperationWithQueryAndBody('scheduleContract', 'POST', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformContractResponse::class);
    }

    public function scheduleContractAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('scheduleContract', 'POST', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformContractResponse::class);
    }

    public function scheduleDiscountSharePolicy(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\SchedulePlatformDiscountSharePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('scheduleDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformDiscountSharePolicyResponse::class);
    }

    public function scheduleDiscountSharePolicyAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('scheduleDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformDiscountSharePolicyResponse::class);
    }

    public function schedulePartner(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\SchedulePlatformPartnerResponse
    {
        return $this->callOperationWithQueryAndBody('schedulePartner', 'POST', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformPartnerResponse::class);
    }

    public function schedulePartnerAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('schedulePartner', 'POST', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformPartnerResponse::class);
    }

    public function schedulePlatformPartners(?bool $test = null, ?array $filter = null, ?array $update = null, ?string $appliedAt = null): Model\SchedulePlatformPartnersResponse
    {
        return $this->callOperationWithQueryAndBody('schedulePlatformPartners', 'POST', '/platform/partners/schedule', ['test' => $test], ['filter' => $filter, 'update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformPartnersResponse::class);
    }

    public function schedulePlatformPartnersAsync(?bool $test = null, ?array $filter = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('schedulePlatformPartners', 'POST', '/platform/partners/schedule', ['test' => $test], ['filter' => $filter, 'update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformPartnersResponse::class);
    }

    public function updatePlatformSetting(?bool $test = null, ?string $defaultWithdrawalMemo = null, ?string $defaultDepositMemo = null, ?bool $supportsMultipleOrderTransfersPerPartner = null, ?bool $adjustSettlementDateAfterHolidayIfEarlier = null, ?bool $deductWht = null, ?string $settlementAmountType = null, ?bool $manualSettlementPerTransfer = null): Model\UpdatePlatformSettingResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformSetting', 'PATCH', '/platform/setting', ['test' => $test], ['manualSettlementPerTransfer' => $manualSettlementPerTransfer, 'defaultWithdrawalMemo' => $defaultWithdrawalMemo, 'defaultDepositMemo' => $defaultDepositMemo, 'supportsMultipleOrderTransfersPerPartner' => $supportsMultipleOrderTransfersPerPartner, 'adjustSettlementDateAfterHolidayIfEarlier' => $adjustSettlementDateAfterHolidayIfEarlier, 'deductWht' => $deductWht, 'settlementAmountType' => $settlementAmountType], Model\UpdatePlatformSettingResponse::class);
    }

    public function updatePlatformSettingAsync(?bool $test = null, ?string $defaultWithdrawalMemo = null, ?string $defaultDepositMemo = null, ?bool $supportsMultipleOrderTransfersPerPartner = null, ?bool $adjustSettlementDateAfterHolidayIfEarlier = null, ?bool $deductWht = null, ?string $settlementAmountType = null, ?bool $manualSettlementPerTransfer = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformSetting', 'PATCH', '/platform/setting', ['test' => $test], ['manualSettlementPerTransfer' => $manualSettlementPerTransfer, 'defaultWithdrawalMemo' => $defaultWithdrawalMemo, 'defaultDepositMemo' => $defaultDepositMemo, 'supportsMultipleOrderTransfersPerPartner' => $supportsMultipleOrderTransfersPerPartner, 'adjustSettlementDateAfterHolidayIfEarlier' => $adjustSettlementDateAfterHolidayIfEarlier, 'deductWht' => $deductWht, 'settlementAmountType' => $settlementAmountType], Model\UpdatePlatformSettingResponse::class);
    }
}
