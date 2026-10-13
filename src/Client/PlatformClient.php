<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\Model;

/**
 * 플랫폼 API 작업과 플랫폼 하위 클라이언트에 접근할 수 있습니다.
 */
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

    /**
     * PlatformClient 객체를 초기화합니다.
     */
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

    /**
     * 주어진 아이디에 대응되는 추가 수수료 정책의 예약 업데이트를 취소합니다.
     */
    public function cancelPlatformAdditionalFeePolicySchedule(?string $id = null, ?bool $test = null): Model\CancelPlatformAdditionalFeePolicyScheduleResponse
    {
        return $this->callOperation('cancelPlatformAdditionalFeePolicySchedule', 'DELETE', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformAdditionalFeePolicyScheduleResponse::class, false);
    }

    /**
     * 주어진 아이디에 대응되는 추가 수수료 정책의 예약 업데이트를 취소합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function cancelPlatformAdditionalFeePolicyScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('cancelPlatformAdditionalFeePolicySchedule', 'DELETE', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformAdditionalFeePolicyScheduleResponse::class, false);
    }

    /**
     * 주어진 아이디에 대응되는 계약의 예약 업데이트를 취소합니다.
     */
    public function cancelPlatformContractSchedule(?string $id = null, ?bool $test = null): Model\CancelPlatformContractScheduleResponse
    {
        return $this->callOperation('cancelPlatformContractSchedule', 'DELETE', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformContractScheduleResponse::class, false);
    }

    /**
     * 주어진 아이디에 대응되는 계약의 예약 업데이트를 취소합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function cancelPlatformContractScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('cancelPlatformContractSchedule', 'DELETE', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformContractScheduleResponse::class, false);
    }

    /**
     * 주어진 아이디에 대응되는 할인 분담의 예약 업데이트를 취소합니다.
     */
    public function cancelPlatformDiscountSharePolicySchedule(?string $id = null, ?bool $test = null): Model\CancelPlatformDiscountSharePolicyScheduleResponse
    {
        return $this->callOperation('cancelPlatformDiscountSharePolicySchedule', 'DELETE', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformDiscountSharePolicyScheduleResponse::class, false);
    }

    /**
     * 주어진 아이디에 대응되는 할인 분담의 예약 업데이트를 취소합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function cancelPlatformDiscountSharePolicyScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('cancelPlatformDiscountSharePolicySchedule', 'DELETE', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformDiscountSharePolicyScheduleResponse::class, false);
    }

    /**
     * 주어진 아이디에 대응되는 파트너의 예약 업데이트를 취소합니다.
     */
    public function cancelPlatformPartnerSchedule(?string $id = null, ?bool $test = null): Model\CancelPlatformPartnerScheduleResponse
    {
        return $this->callOperation('cancelPlatformPartnerSchedule', 'DELETE', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformPartnerScheduleResponse::class, false);
    }

    /**
     * 주어진 아이디에 대응되는 파트너의 예약 업데이트를 취소합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function cancelPlatformPartnerScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('cancelPlatformPartnerSchedule', 'DELETE', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], Model\CancelPlatformPartnerScheduleResponse::class, false);
    }

    /**
     * 주어진 아이디에 대응되는 추가 수수료 정책의 예약 업데이트를 조회합니다.
     */
    public function getPlatformAdditionalFeePolicySchedule(?string $id = null, ?bool $test = null): Model\PlatformAdditionalFeePolicy
    {
        return $this->callOperation('getPlatformAdditionalFeePolicySchedule', 'GET', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformAdditionalFeePolicy::class, false);
    }

    /**
     * 주어진 아이디에 대응되는 추가 수수료 정책의 예약 업데이트를 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformAdditionalFeePolicyScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformAdditionalFeePolicySchedule', 'GET', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformAdditionalFeePolicy::class, false);
    }

    /**
     * 주어진 아이디에 대응되는 계약의 예약 업데이트를 조회합니다.
     */
    public function getPlatformContractSchedule(?string $id = null, ?bool $test = null): Model\PlatformContract
    {
        return $this->callOperation('getPlatformContractSchedule', 'GET', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformContract::class, false);
    }

    /**
     * 주어진 아이디에 대응되는 계약의 예약 업데이트를 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformContractScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformContractSchedule', 'GET', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformContract::class, false);
    }

    /**
     * 할인 분담 정책 다건 조회 시 필요한 필터 옵션을 조회합니다.
     */
    public function getPlatformDiscountSharePolicyFilterOptions(?bool $test = null, ?bool $isArchived = null): Model\PlatformDiscountSharePolicyFilterOptions
    {
        return $this->callOperation('getPlatformDiscountSharePolicyFilterOptions', 'GET', '/platform/discount-share-policy-filter-options', ['test' => $test, 'isArchived' => $isArchived], Model\PlatformDiscountSharePolicyFilterOptions::class, false);
    }

    /**
     * 할인 분담 정책 다건 조회 시 필요한 필터 옵션을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformDiscountSharePolicyFilterOptionsAsync(?bool $test = null, ?bool $isArchived = null): Future
    {
        return $this->callOperationAsync('getPlatformDiscountSharePolicyFilterOptions', 'GET', '/platform/discount-share-policy-filter-options', ['test' => $test, 'isArchived' => $isArchived], Model\PlatformDiscountSharePolicyFilterOptions::class, false);
    }

    /**
     * 주어진 아이디에 대응되는 할인 분담의 예약 업데이트를 조회합니다.
     */
    public function getPlatformDiscountSharePolicySchedule(?string $id = null, ?bool $test = null): Model\PlatformDiscountSharePolicy
    {
        return $this->callOperation('getPlatformDiscountSharePolicySchedule', 'GET', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformDiscountSharePolicy::class, false);
    }

    /**
     * 주어진 아이디에 대응되는 할인 분담의 예약 업데이트를 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformDiscountSharePolicyScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformDiscountSharePolicySchedule', 'GET', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformDiscountSharePolicy::class, false);
    }

    /**
     * 파트너 다건 조회 시 필요한 필터 옵션을 조회합니다.
     */
    public function getPlatformPartnerFilterOptions(?bool $test = null, ?bool $isArchived = null): Model\PlatformPartnerFilterOptions
    {
        return $this->callOperation('getPlatformPartnerFilterOptions', 'GET', '/platform/partner-filter-options', ['test' => $test, 'isArchived' => $isArchived], Model\PlatformPartnerFilterOptions::class, false);
    }

    /**
     * 파트너 다건 조회 시 필요한 필터 옵션을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformPartnerFilterOptionsAsync(?bool $test = null, ?bool $isArchived = null): Future
    {
        return $this->callOperationAsync('getPlatformPartnerFilterOptions', 'GET', '/platform/partner-filter-options', ['test' => $test, 'isArchived' => $isArchived], Model\PlatformPartnerFilterOptions::class, false);
    }

    /**
     * 주어진 아이디에 대응되는 파트너의 예약 업데이트를 조회합니다.
     */
    public function getPlatformPartnerSchedule(?string $id = null, ?bool $test = null): Model\PlatformPartner
    {
        return $this->callOperation('getPlatformPartnerSchedule', 'GET', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformPartner::class, false);
    }

    /**
     * 주어진 아이디에 대응되는 파트너의 예약 업데이트를 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformPartnerScheduleAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformPartnerSchedule', 'GET', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], Model\PlatformPartner::class, false);
    }

    /**
     * 플랫폼 설정 조회 기능입니다.
     * 설정 정보를 조회합니다.
     */
    public function getPlatformSetting(?bool $test = null): Model\PlatformSetting
    {
        return $this->callOperation('getPlatformSetting', 'GET', '/platform/setting', ['test' => $test], Model\PlatformSetting::class, false);
    }

    /**
     * 플랫폼 설정 조회 기능입니다.
     * 설정 정보를 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformSettingAsync(?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformSetting', 'GET', '/platform/setting', ['test' => $test], Model\PlatformSetting::class, false);
    }

    /**
     *  기능입니다.
     */
    public function rescheduleAdditionalFeePolicy(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\ReschedulePlatformAdditionalFeePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('rescheduleAdditionalFeePolicy', 'PUT', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformAdditionalFeePolicyResponse::class);
    }

    /**
     *  기능입니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function rescheduleAdditionalFeePolicyAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('rescheduleAdditionalFeePolicy', 'PUT', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformAdditionalFeePolicyResponse::class);
    }

    /**
     * 주어진 아이디에 대응되는 계약에 예약 업데이트를 재설정합니다.
     */
    public function rescheduleContract(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\ReschedulePlatformContractResponse
    {
        return $this->callOperationWithQueryAndBody('rescheduleContract', 'PUT', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformContractResponse::class);
    }

    /**
     * 주어진 아이디에 대응되는 계약에 예약 업데이트를 재설정합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function rescheduleContractAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('rescheduleContract', 'PUT', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformContractResponse::class);
    }

    /**
     * 주어진 아이디에 대응되는 할인 분담에 예약 업데이트를 재설정합니다.
     */
    public function rescheduleDiscountSharePolicy(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\ReschedulePlatformDiscountSharePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('rescheduleDiscountSharePolicy', 'PUT', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformDiscountSharePolicyResponse::class);
    }

    /**
     * 주어진 아이디에 대응되는 할인 분담에 예약 업데이트를 재설정합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function rescheduleDiscountSharePolicyAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('rescheduleDiscountSharePolicy', 'PUT', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformDiscountSharePolicyResponse::class);
    }

    /**
     * 주어진 아이디에 대응되는 파트너에 예약 업데이트를 재설정합니다.
     */
    public function reschedulePartner(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\ReschedulePlatformPartnerResponse
    {
        return $this->callOperationWithQueryAndBody('reschedulePartner', 'PUT', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformPartnerResponse::class);
    }

    /**
     * 주어진 아이디에 대응되는 파트너에 예약 업데이트를 재설정합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function reschedulePartnerAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('reschedulePartner', 'PUT', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\ReschedulePlatformPartnerResponse::class);
    }

    /**
     * 주어진 아이디에 대응되는 추가 수수료 정책에 업데이트를 예약합니다.
     */
    public function scheduleAdditionalFeePolicy(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\SchedulePlatformAdditionalFeePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('scheduleAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformAdditionalFeePolicyResponse::class);
    }

    /**
     * 주어진 아이디에 대응되는 추가 수수료 정책에 업데이트를 예약합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function scheduleAdditionalFeePolicyAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('scheduleAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformAdditionalFeePolicyResponse::class);
    }

    /**
     * 주어진 아이디에 대응되는 계약에 업데이트를 예약합니다.
     */
    public function scheduleContract(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\SchedulePlatformContractResponse
    {
        return $this->callOperationWithQueryAndBody('scheduleContract', 'POST', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformContractResponse::class);
    }

    /**
     * 주어진 아이디에 대응되는 계약에 업데이트를 예약합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function scheduleContractAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('scheduleContract', 'POST', '/platform/contracts/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformContractResponse::class);
    }

    /**
     * 주어진 아이디에 대응되는 할인 분담에 업데이트를 예약합니다.
     */
    public function scheduleDiscountSharePolicy(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\SchedulePlatformDiscountSharePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('scheduleDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformDiscountSharePolicyResponse::class);
    }

    /**
     * 주어진 아이디에 대응되는 할인 분담에 업데이트를 예약합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function scheduleDiscountSharePolicyAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('scheduleDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformDiscountSharePolicyResponse::class);
    }

    /**
     * 주어진 아이디에 대응되는 파트너에 업데이트를 예약합니다.
     */
    public function schedulePartner(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Model\SchedulePlatformPartnerResponse
    {
        return $this->callOperationWithQueryAndBody('schedulePartner', 'POST', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformPartnerResponse::class);
    }

    /**
     * 주어진 아이디에 대응되는 파트너에 업데이트를 예약합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function schedulePartnerAsync(?string $id = null, ?bool $test = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('schedulePartner', 'POST', '/platform/partners/{id}/schedule', ['id' => $id, 'test' => $test], ['update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformPartnerResponse::class);
    }

    /**
     *  기능입니다.
     */
    public function schedulePlatformPartners(?bool $test = null, ?array $filter = null, ?array $update = null, ?string $appliedAt = null): Model\SchedulePlatformPartnersResponse
    {
        return $this->callOperationWithQueryAndBody('schedulePlatformPartners', 'POST', '/platform/partners/schedule', ['test' => $test], ['filter' => $filter, 'update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformPartnersResponse::class);
    }

    /**
     *  기능입니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function schedulePlatformPartnersAsync(?bool $test = null, ?array $filter = null, ?array $update = null, ?string $appliedAt = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('schedulePlatformPartners', 'POST', '/platform/partners/schedule', ['test' => $test], ['filter' => $filter, 'update' => $update, 'appliedAt' => $appliedAt], Model\SchedulePlatformPartnersResponse::class);
    }

    /**
     * 플랫폼 설정 업데이트 기능입니다.
     * 설정 정보를 업데이트합니다.
     */
    public function updatePlatformSetting(?bool $test = null, ?string $defaultWithdrawalMemo = null, ?string $defaultDepositMemo = null, ?bool $supportsMultipleOrderTransfersPerPartner = null, ?bool $adjustSettlementDateAfterHolidayIfEarlier = null, ?bool $deductWht = null, ?string $settlementAmountType = null, ?bool $manualSettlementPerTransfer = null): Model\UpdatePlatformSettingResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformSetting', 'PATCH', '/platform/setting', ['test' => $test], ['manualSettlementPerTransfer' => $manualSettlementPerTransfer, 'defaultWithdrawalMemo' => $defaultWithdrawalMemo, 'defaultDepositMemo' => $defaultDepositMemo, 'supportsMultipleOrderTransfersPerPartner' => $supportsMultipleOrderTransfersPerPartner, 'adjustSettlementDateAfterHolidayIfEarlier' => $adjustSettlementDateAfterHolidayIfEarlier, 'deductWht' => $deductWht, 'settlementAmountType' => $settlementAmountType], Model\UpdatePlatformSettingResponse::class);
    }

    /**
     * 플랫폼 설정 업데이트 기능입니다.
     * 설정 정보를 업데이트합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function updatePlatformSettingAsync(?bool $test = null, ?string $defaultWithdrawalMemo = null, ?string $defaultDepositMemo = null, ?bool $supportsMultipleOrderTransfersPerPartner = null, ?bool $adjustSettlementDateAfterHolidayIfEarlier = null, ?bool $deductWht = null, ?string $settlementAmountType = null, ?bool $manualSettlementPerTransfer = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformSetting', 'PATCH', '/platform/setting', ['test' => $test], ['manualSettlementPerTransfer' => $manualSettlementPerTransfer, 'defaultWithdrawalMemo' => $defaultWithdrawalMemo, 'defaultDepositMemo' => $defaultDepositMemo, 'supportsMultipleOrderTransfersPerPartner' => $supportsMultipleOrderTransfersPerPartner, 'adjustSettlementDateAfterHolidayIfEarlier' => $adjustSettlementDateAfterHolidayIfEarlier, 'deductWht' => $deductWht, 'settlementAmountType' => $settlementAmountType], Model\UpdatePlatformSettingResponse::class);
    }
}
