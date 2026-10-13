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
     *
     * @param  string|null  $id  추가 수수료 정책 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function archivePlatformAdditionalFeePolicy(?string $id = null, ?bool $test = null): Model\ArchivePlatformAdditionalFeePolicyResponse
    {
        return $this->callOperation('archivePlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformAdditionalFeePolicyResponse::class, false);
    }

    /**
     * 추가 수수료 정책 보관 기능입니다.
     * 주어진 아이디에 대응되는 추가 수수료 정책을 보관합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $id  추가 수수료 정책 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function archivePlatformAdditionalFeePolicyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('archivePlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformAdditionalFeePolicyResponse::class, false);
    }

    /**
     * 계약 보관 기능입니다.
     * 주어진 아이디에 대응되는 계약을 보관합니다.
     *
     * @param  string|null  $id  계약 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function archivePlatformContract(?string $id = null, ?bool $test = null): Model\ArchivePlatformContractResponse
    {
        return $this->callOperation('archivePlatformContract', 'POST', '/platform/contracts/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformContractResponse::class, false);
    }

    /**
     * 계약 보관 기능입니다.
     * 주어진 아이디에 대응되는 계약을 보관합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $id  계약 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function archivePlatformContractAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('archivePlatformContract', 'POST', '/platform/contracts/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformContractResponse::class, false);
    }

    /**
     * 할인 분담 정책 보관 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 보관합니다.
     *
     * @param  string|null  $id  할인 분담 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function archivePlatformDiscountSharePolicy(?string $id = null, ?bool $test = null): Model\ArchivePlatformDiscountSharePolicyResponse
    {
        return $this->callOperation('archivePlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformDiscountSharePolicyResponse::class, false);
    }

    /**
     * 할인 분담 정책 보관 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 보관합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $id  할인 분담 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function archivePlatformDiscountSharePolicyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('archivePlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/archive', ['id' => $id, 'test' => $test], Model\ArchivePlatformDiscountSharePolicyResponse::class, false);
    }

    /**
     * 추가 수수료 정책 생성 기능입니다.
     * 새로운 추가 수수료 정책을 생성합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $id  생성할 추가 수수료 정책 아이디: 명시하지 않으면 id 가 임의로 생성됩니다.
     * @param  string|null  $name  이름
     * @param  array<string, mixed>|null  $fee  수수료 계산 방식을 특정하기 위한 입력 정보: 정률 수수료를 설정하고 싶은 경우 `fixedRate` 필드에, 정액 수수료를 설정하고 싶은 경우 `fixedAmount` 필드에 값을 명시해 요청합니다. 두 필드 모두 값이 들어있지 않은 경우 요청이 거절됩니다.
     * @param  string|null  $memo  메모
     * @param  string|null  $vatPayer  금액 부담 주체: 플랫폼에서 발생한 결제 수수료, 부가세 등 금액을 부담하는 주체를 나타냅니다.
     */
    public function createPlatformAdditionalFeePolicy(?bool $test = null, ?string $id = null, ?string $name = null, ?array $fee = null, ?string $memo = null, ?string $vatPayer = null): Model\CreatePlatformAdditionalFeePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies', ['test' => $test], ['id' => $id, 'name' => $name, 'fee' => $fee, 'memo' => $memo, 'vatPayer' => $vatPayer], Model\CreatePlatformAdditionalFeePolicyResponse::class);
    }

    /**
     * 추가 수수료 정책 생성 기능입니다.
     * 새로운 추가 수수료 정책을 생성합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $id  생성할 추가 수수료 정책 아이디: 명시하지 않으면 id 가 임의로 생성됩니다.
     * @param  string|null  $name  이름
     * @param  array<string, mixed>|null  $fee  수수료 계산 방식을 특정하기 위한 입력 정보: 정률 수수료를 설정하고 싶은 경우 `fixedRate` 필드에, 정액 수수료를 설정하고 싶은 경우 `fixedAmount` 필드에 값을 명시해 요청합니다. 두 필드 모두 값이 들어있지 않은 경우 요청이 거절됩니다.
     * @param  string|null  $memo  메모
     * @param  string|null  $vatPayer  금액 부담 주체: 플랫폼에서 발생한 결제 수수료, 부가세 등 금액을 부담하는 주체를 나타냅니다.
     */
    public function createPlatformAdditionalFeePolicyAsync(?bool $test = null, ?string $id = null, ?string $name = null, ?array $fee = null, ?string $memo = null, ?string $vatPayer = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies', ['test' => $test], ['id' => $id, 'name' => $name, 'fee' => $fee, 'memo' => $memo, 'vatPayer' => $vatPayer], Model\CreatePlatformAdditionalFeePolicyResponse::class);
    }

    /**
     * 계약 생성 기능입니다.
     * 새로운 계약을 생성합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $id  계약에 부여할 고유 아이디: 명시하지 않는 경우 포트원이 임의의 아이디를 발급해드립니다.
     * @param  string|null  $name  계약 이름
     * @param  string|null  $memo  계약 내부 표기를 위한 메모
     * @param  array<string, mixed>|null  $platformFee  수수료 계산 방식을 특정하기 위한 입력 정보: 정률 수수료를 설정하고 싶은 경우 `fixedRate` 필드에, 정액 수수료를 설정하고 싶은 경우 `fixedAmount` 필드에 값을 명시해 요청합니다. 두 필드 모두 값이 들어있지 않은 경우 요청이 거절됩니다.
     * @param  array<string, mixed>|null  $settlementCycle  플랫폼 정산 주기 입력 정보
     * @param  string|null  $platformFeeVatPayer  금액 부담 주체: 플랫폼에서 발생한 결제 수수료, 부가세 등 금액을 부담하는 주체를 나타냅니다.
     * @param  bool|null  $subtractPaymentVatAmount  정산 시 결제금액 부가세 감액 여부
     */
    public function createPlatformContract(?bool $test = null, ?string $id = null, ?string $name = null, ?string $memo = null, ?array $platformFee = null, ?array $settlementCycle = null, ?string $platformFeeVatPayer = null, ?bool $subtractPaymentVatAmount = null): Model\CreatePlatformContractResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformContract', 'POST', '/platform/contracts', ['test' => $test], ['id' => $id, 'name' => $name, 'memo' => $memo, 'platformFee' => $platformFee, 'settlementCycle' => $settlementCycle, 'platformFeeVatPayer' => $platformFeeVatPayer, 'subtractPaymentVatAmount' => $subtractPaymentVatAmount], Model\CreatePlatformContractResponse::class);
    }

    /**
     * 계약 생성 기능입니다.
     * 새로운 계약을 생성합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $id  계약에 부여할 고유 아이디: 명시하지 않는 경우 포트원이 임의의 아이디를 발급해드립니다.
     * @param  string|null  $name  계약 이름
     * @param  string|null  $memo  계약 내부 표기를 위한 메모
     * @param  array<string, mixed>|null  $platformFee  수수료 계산 방식을 특정하기 위한 입력 정보: 정률 수수료를 설정하고 싶은 경우 `fixedRate` 필드에, 정액 수수료를 설정하고 싶은 경우 `fixedAmount` 필드에 값을 명시해 요청합니다. 두 필드 모두 값이 들어있지 않은 경우 요청이 거절됩니다.
     * @param  array<string, mixed>|null  $settlementCycle  플랫폼 정산 주기 입력 정보
     * @param  string|null  $platformFeeVatPayer  금액 부담 주체: 플랫폼에서 발생한 결제 수수료, 부가세 등 금액을 부담하는 주체를 나타냅니다.
     * @param  bool|null  $subtractPaymentVatAmount  정산 시 결제금액 부가세 감액 여부
     */
    public function createPlatformContractAsync(?bool $test = null, ?string $id = null, ?string $name = null, ?string $memo = null, ?array $platformFee = null, ?array $settlementCycle = null, ?string $platformFeeVatPayer = null, ?bool $subtractPaymentVatAmount = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformContract', 'POST', '/platform/contracts', ['test' => $test], ['id' => $id, 'name' => $name, 'memo' => $memo, 'platformFee' => $platformFee, 'settlementCycle' => $settlementCycle, 'platformFeeVatPayer' => $platformFeeVatPayer, 'subtractPaymentVatAmount' => $subtractPaymentVatAmount], Model\CreatePlatformContractResponse::class);
    }

    /**
     * 할인 분담 정책 생성 기능입니다.
     * 새로운 할인 분담을 생성합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $id  할인 분담에 부여할 고유 아이디: 명시하지 않는 경우 포트원이 임의의 아이디를 발급해드립니다.
     * @param  string|null  $name  할인 분담에 부여할 이름
     * @param  int|null  $partnerShareRate  파트너가 분담할 할인금액의 비율을 의미하는 밀리 퍼센트 단위 (10^-5) 의 음이 아닌 정수이며, 파트너가 부담할 금액은 `할인금액 * partnerShareRate * 10^5` 로 책정합니다.
     * @param  string|null  $memo  해당 할인 분담에 대한 메모 ex) 파트너 브랜드 쿠폰
     */
    public function createPlatformDiscountSharePolicy(?bool $test = null, ?string $id = null, ?string $name = null, ?int $partnerShareRate = null, ?string $memo = null): Model\CreatePlatformDiscountSharePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('createPlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies', ['test' => $test], ['id' => $id, 'name' => $name, 'partnerShareRate' => $partnerShareRate, 'memo' => $memo], Model\CreatePlatformDiscountSharePolicyResponse::class);
    }

    /**
     * 할인 분담 정책 생성 기능입니다.
     * 새로운 할인 분담을 생성합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $id  할인 분담에 부여할 고유 아이디: 명시하지 않는 경우 포트원이 임의의 아이디를 발급해드립니다.
     * @param  string|null  $name  할인 분담에 부여할 이름
     * @param  int|null  $partnerShareRate  파트너가 분담할 할인금액의 비율을 의미하는 밀리 퍼센트 단위 (10^-5) 의 음이 아닌 정수이며, 파트너가 부담할 금액은 `할인금액 * partnerShareRate * 10^5` 로 책정합니다.
     * @param  string|null  $memo  해당 할인 분담에 대한 메모 ex) 파트너 브랜드 쿠폰
     */
    public function createPlatformDiscountSharePolicyAsync(?bool $test = null, ?string $id = null, ?string $name = null, ?int $partnerShareRate = null, ?string $memo = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('createPlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies', ['test' => $test], ['id' => $id, 'name' => $name, 'partnerShareRate' => $partnerShareRate, 'memo' => $memo], Model\CreatePlatformDiscountSharePolicyResponse::class);
    }

    /**
     * 추가 수수료 정책 다건 조회 기능입니다.
     * 여러 추가 수수료 정책을 조회합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  추가 수수료 정책 다건 조회를 위한 필터 조건
     */
    public function getPlatformAdditionalFeePolicies(?bool $test = null, ?array $page = null, ?array $filter = null): Model\GetPlatformAdditionalFeePoliciesResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformAdditionalFeePolicies', 'GET', '/platform/additional-fee-policies', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformAdditionalFeePoliciesResponse::class);
    }

    /**
     * 추가 수수료 정책 다건 조회 기능입니다.
     * 여러 추가 수수료 정책을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  추가 수수료 정책 다건 조회를 위한 필터 조건
     */
    public function getPlatformAdditionalFeePoliciesAsync(?bool $test = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformAdditionalFeePolicies', 'GET', '/platform/additional-fee-policies', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformAdditionalFeePoliciesResponse::class);
    }

    /**
     * 추가 수수료 정책 조회 기능입니다.
     * 주어진 아이디에 대응되는 추가 수수료 정책을 조회합니다.
     *
     * @param  string|null  $id  조회할 추가 수수료 정책 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function getPlatformAdditionalFeePolicy(?string $id = null, ?bool $test = null): Model\PlatformAdditionalFeePolicy
    {
        return $this->callOperation('getPlatformAdditionalFeePolicy', 'GET', '/platform/additional-fee-policies/{id}', ['id' => $id, 'test' => $test], Model\PlatformAdditionalFeePolicy::class, false);
    }

    /**
     * 추가 수수료 정책 조회 기능입니다.
     * 주어진 아이디에 대응되는 추가 수수료 정책을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $id  조회할 추가 수수료 정책 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function getPlatformAdditionalFeePolicyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformAdditionalFeePolicy', 'GET', '/platform/additional-fee-policies/{id}', ['id' => $id, 'test' => $test], Model\PlatformAdditionalFeePolicy::class, false);
    }

    /**
     * 계약 조회 기능입니다.
     * 주어진 아이디에 대응되는 계약을 조회합니다.
     *
     * @param  string|null  $id  조회할 계약 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function getPlatformContract(?string $id = null, ?bool $test = null): Model\PlatformContract
    {
        return $this->callOperation('getPlatformContract', 'GET', '/platform/contracts/{id}', ['id' => $id, 'test' => $test], Model\PlatformContract::class, false);
    }

    /**
     * 계약 조회 기능입니다.
     * 주어진 아이디에 대응되는 계약을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $id  조회할 계약 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function getPlatformContractAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformContract', 'GET', '/platform/contracts/{id}', ['id' => $id, 'test' => $test], Model\PlatformContract::class, false);
    }

    /**
     * 계약 다건 조회 기능입니다.
     * 여러 계약을 조회합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  계약 다건 조회를 위한 필터 조건
     */
    public function getPlatformContracts(?bool $test = null, ?array $page = null, ?array $filter = null): Model\GetPlatformContractsResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformContracts', 'GET', '/platform/contracts', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformContractsResponse::class);
    }

    /**
     * 계약 다건 조회 기능입니다.
     * 여러 계약을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  계약 다건 조회를 위한 필터 조건
     */
    public function getPlatformContractsAsync(?bool $test = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformContracts', 'GET', '/platform/contracts', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformContractsResponse::class);
    }

    /**
     * 할인 분담 정책 다건 조회 기능입니다.
     * 여러 할인 분담을 조회합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  할인 분담 정책 다건 조회를 위한 필터 조건
     */
    public function getPlatformDiscountSharePolicies(?bool $test = null, ?array $page = null, ?array $filter = null): Model\GetPlatformDiscountSharePoliciesResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformDiscountSharePolicies', 'GET', '/platform/discount-share-policies', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformDiscountSharePoliciesResponse::class);
    }

    /**
     * 할인 분담 정책 다건 조회 기능입니다.
     * 여러 할인 분담을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  할인 분담 정책 다건 조회를 위한 필터 조건
     */
    public function getPlatformDiscountSharePoliciesAsync(?bool $test = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformDiscountSharePolicies', 'GET', '/platform/discount-share-policies', ['test' => $test], ['page' => $page, 'filter' => $filter], Model\GetPlatformDiscountSharePoliciesResponse::class);
    }

    /**
     * 할인 분담 정책 조회 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 조회합니다.
     *
     * @param  string|null  $id  조회할 할인 분담 정책 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function getPlatformDiscountSharePolicy(?string $id = null, ?bool $test = null): Model\PlatformDiscountSharePolicy
    {
        return $this->callOperation('getPlatformDiscountSharePolicy', 'GET', '/platform/discount-share-policies/{id}', ['id' => $id, 'test' => $test], Model\PlatformDiscountSharePolicy::class, false);
    }

    /**
     * 할인 분담 정책 조회 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $id  조회할 할인 분담 정책 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function getPlatformDiscountSharePolicyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformDiscountSharePolicy', 'GET', '/platform/discount-share-policies/{id}', ['id' => $id, 'test' => $test], Model\PlatformDiscountSharePolicy::class, false);
    }

    /**
     * 추가 수수료 정책 복원 기능입니다.
     * 주어진 아이디에 대응되는 추가 수수료 정책을 복원합니다.
     *
     * @param  string|null  $id  추가 수수료 정책 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function recoverPlatformAdditionalFeePolicy(?string $id = null, ?bool $test = null): Model\RecoverPlatformAdditionalFeePolicyResponse
    {
        return $this->callOperation('recoverPlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformAdditionalFeePolicyResponse::class, false);
    }

    /**
     * 추가 수수료 정책 복원 기능입니다.
     * 주어진 아이디에 대응되는 추가 수수료 정책을 복원합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $id  추가 수수료 정책 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function recoverPlatformAdditionalFeePolicyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('recoverPlatformAdditionalFeePolicy', 'POST', '/platform/additional-fee-policies/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformAdditionalFeePolicyResponse::class, false);
    }

    /**
     * 계약 복원 기능입니다.
     * 주어진 아이디에 대응되는 계약을 복원합니다.
     *
     * @param  string|null  $id  계약 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function recoverPlatformContract(?string $id = null, ?bool $test = null): Model\RecoverPlatformContractResponse
    {
        return $this->callOperation('recoverPlatformContract', 'POST', '/platform/contracts/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformContractResponse::class, false);
    }

    /**
     * 계약 복원 기능입니다.
     * 주어진 아이디에 대응되는 계약을 복원합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $id  계약 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function recoverPlatformContractAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('recoverPlatformContract', 'POST', '/platform/contracts/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformContractResponse::class, false);
    }

    /**
     * 할인 분담 정책 복원 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 복원합니다.
     *
     * @param  string|null  $id  할인 분담 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function recoverPlatformDiscountSharePolicy(?string $id = null, ?bool $test = null): Model\RecoverPlatformDiscountSharePolicyResponse
    {
        return $this->callOperation('recoverPlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformDiscountSharePolicyResponse::class, false);
    }

    /**
     * 할인 분담 정책 복원 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 복원합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $id  할인 분담 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function recoverPlatformDiscountSharePolicyAsync(?string $id = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('recoverPlatformDiscountSharePolicy', 'POST', '/platform/discount-share-policies/{id}/recover', ['id' => $id, 'test' => $test], Model\RecoverPlatformDiscountSharePolicyResponse::class, false);
    }

    /**
     * 추가 수수료 정책 수정 기능입니다.
     * 주어진 아이디에 대응되는 추가 수수료 정책을 업데이트합니다.
     *
     * @param  string|null  $id  업데이트할 추가 수수료 정책 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $fee  수수료 계산 방식을 특정하기 위한 입력 정보: 정률 수수료를 설정하고 싶은 경우 `fixedRate` 필드에, 정액 수수료를 설정하고 싶은 경우 `fixedAmount` 필드에 값을 명시해 요청합니다. 두 필드 모두 값이 들어있지 않은 경우 요청이 거절됩니다.
     * @param  string|null  $name  추가 수수료 정책 이름
     * @param  string|null  $memo  해당 추가 수수료 정책에 대한 메모
     * @param  string|null  $vatPayer  금액 부담 주체: 플랫폼에서 발생한 결제 수수료, 부가세 등 금액을 부담하는 주체를 나타냅니다.
     */
    public function updatePlatformAdditionalFeePolicy(?string $id = null, ?bool $test = null, ?array $fee = null, ?string $name = null, ?string $memo = null, ?string $vatPayer = null): Model\UpdatePlatformAdditionalFeePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformAdditionalFeePolicy', 'PATCH', '/platform/additional-fee-policies/{id}', ['id' => $id, 'test' => $test], ['fee' => $fee, 'name' => $name, 'memo' => $memo, 'vatPayer' => $vatPayer], Model\UpdatePlatformAdditionalFeePolicyResponse::class);
    }

    /**
     * 추가 수수료 정책 수정 기능입니다.
     * 주어진 아이디에 대응되는 추가 수수료 정책을 업데이트합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $id  업데이트할 추가 수수료 정책 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $fee  수수료 계산 방식을 특정하기 위한 입력 정보: 정률 수수료를 설정하고 싶은 경우 `fixedRate` 필드에, 정액 수수료를 설정하고 싶은 경우 `fixedAmount` 필드에 값을 명시해 요청합니다. 두 필드 모두 값이 들어있지 않은 경우 요청이 거절됩니다.
     * @param  string|null  $name  추가 수수료 정책 이름
     * @param  string|null  $memo  해당 추가 수수료 정책에 대한 메모
     * @param  string|null  $vatPayer  금액 부담 주체: 플랫폼에서 발생한 결제 수수료, 부가세 등 금액을 부담하는 주체를 나타냅니다.
     */
    public function updatePlatformAdditionalFeePolicyAsync(?string $id = null, ?bool $test = null, ?array $fee = null, ?string $name = null, ?string $memo = null, ?string $vatPayer = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformAdditionalFeePolicy', 'PATCH', '/platform/additional-fee-policies/{id}', ['id' => $id, 'test' => $test], ['fee' => $fee, 'name' => $name, 'memo' => $memo, 'vatPayer' => $vatPayer], Model\UpdatePlatformAdditionalFeePolicyResponse::class);
    }

    /**
     * 계약 수정 기능입니다.
     * 주어진 아이디에 대응되는 계약을 업데이트합니다.
     *
     * @param  string|null  $id  업데이트할 계약 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $name  계약 이름
     * @param  string|null  $memo  계약 내부 표기를 위한 메모
     * @param  array<string, mixed>|null  $platformFee  수수료 계산 방식을 특정하기 위한 입력 정보: 정률 수수료를 설정하고 싶은 경우 `fixedRate` 필드에, 정액 수수료를 설정하고 싶은 경우 `fixedAmount` 필드에 값을 명시해 요청합니다. 두 필드 모두 값이 들어있지 않은 경우 요청이 거절됩니다.
     * @param  array<string, mixed>|null  $settlementCycle  플랫폼 정산 주기 입력 정보
     * @param  string|null  $platformFeeVatPayer  금액 부담 주체: 플랫폼에서 발생한 결제 수수료, 부가세 등 금액을 부담하는 주체를 나타냅니다.
     * @param  bool|null  $subtractPaymentVatAmount  정산 시 결제금액 부가세 감액 여부
     */
    public function updatePlatformContract(?string $id = null, ?bool $test = null, ?string $name = null, ?string $memo = null, ?array $platformFee = null, ?array $settlementCycle = null, ?string $platformFeeVatPayer = null, ?bool $subtractPaymentVatAmount = null): Model\UpdatePlatformContractResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformContract', 'PATCH', '/platform/contracts/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'memo' => $memo, 'platformFee' => $platformFee, 'settlementCycle' => $settlementCycle, 'platformFeeVatPayer' => $platformFeeVatPayer, 'subtractPaymentVatAmount' => $subtractPaymentVatAmount], Model\UpdatePlatformContractResponse::class);
    }

    /**
     * 계약 수정 기능입니다.
     * 주어진 아이디에 대응되는 계약을 업데이트합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $id  업데이트할 계약 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $name  계약 이름
     * @param  string|null  $memo  계약 내부 표기를 위한 메모
     * @param  array<string, mixed>|null  $platformFee  수수료 계산 방식을 특정하기 위한 입력 정보: 정률 수수료를 설정하고 싶은 경우 `fixedRate` 필드에, 정액 수수료를 설정하고 싶은 경우 `fixedAmount` 필드에 값을 명시해 요청합니다. 두 필드 모두 값이 들어있지 않은 경우 요청이 거절됩니다.
     * @param  array<string, mixed>|null  $settlementCycle  플랫폼 정산 주기 입력 정보
     * @param  string|null  $platformFeeVatPayer  금액 부담 주체: 플랫폼에서 발생한 결제 수수료, 부가세 등 금액을 부담하는 주체를 나타냅니다.
     * @param  bool|null  $subtractPaymentVatAmount  정산 시 결제금액 부가세 감액 여부
     */
    public function updatePlatformContractAsync(?string $id = null, ?bool $test = null, ?string $name = null, ?string $memo = null, ?array $platformFee = null, ?array $settlementCycle = null, ?string $platformFeeVatPayer = null, ?bool $subtractPaymentVatAmount = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformContract', 'PATCH', '/platform/contracts/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'memo' => $memo, 'platformFee' => $platformFee, 'settlementCycle' => $settlementCycle, 'platformFeeVatPayer' => $platformFeeVatPayer, 'subtractPaymentVatAmount' => $subtractPaymentVatAmount], Model\UpdatePlatformContractResponse::class);
    }

    /**
     * 할인 분담 정책 수정 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 업데이트합니다.
     *
     * @param  string|null  $id  업데이트할 할인 분담 정책 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $name  할인 분담 정책 이름
     * @param  int|null  $partnerShareRate  할인 분담율: 파트너가 분담할 할인금액의 비율을 의미하는 밀리 퍼센트 단위 (10^-5) 의 음이 아닌 정수이며, 파트너가 부담할 금액은 `할인금액 * partnerShareRate * 10^5` 로 책정합니다.
     * @param  string|null  $memo  해당 할인 분담에 대한 메모
     */
    public function updatePlatformDiscountSharePolicy(?string $id = null, ?bool $test = null, ?string $name = null, ?int $partnerShareRate = null, ?string $memo = null): Model\UpdatePlatformDiscountSharePolicyResponse
    {
        return $this->callOperationWithQueryAndBody('updatePlatformDiscountSharePolicy', 'PATCH', '/platform/discount-share-policies/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'partnerShareRate' => $partnerShareRate, 'memo' => $memo], Model\UpdatePlatformDiscountSharePolicyResponse::class);
    }

    /**
     * 할인 분담 정책 수정 기능입니다.
     * 주어진 아이디에 대응되는 할인 분담을 업데이트합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $id  업데이트할 할인 분담 정책 아이디
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $name  할인 분담 정책 이름
     * @param  int|null  $partnerShareRate  할인 분담율: 파트너가 분담할 할인금액의 비율을 의미하는 밀리 퍼센트 단위 (10^-5) 의 음이 아닌 정수이며, 파트너가 부담할 금액은 `할인금액 * partnerShareRate * 10^5` 로 책정합니다.
     * @param  string|null  $memo  해당 할인 분담에 대한 메모
     */
    public function updatePlatformDiscountSharePolicyAsync(?string $id = null, ?bool $test = null, ?string $name = null, ?int $partnerShareRate = null, ?string $memo = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('updatePlatformDiscountSharePolicy', 'PATCH', '/platform/discount-share-policies/{id}', ['id' => $id, 'test' => $test], ['name' => $name, 'partnerShareRate' => $partnerShareRate, 'memo' => $memo], Model\UpdatePlatformDiscountSharePolicyResponse::class);
    }
}
