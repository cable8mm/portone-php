<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 플랫폼 지급 API 작업을 제공합니다.
 */
final class PayoutClient extends AbstractClient
{
    /**
     * 일괄 지급 완료 처리 기능입니다.
     * 선택한 정산내역 아이디들로 일괄 지급을 완료 처리 합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $bulkPayoutId  일괄 지급 아이디
     * @param  string|null  $name  일괄 지급 이름
     * @param  array<string, mixed>|null  $partnerSettlementIds  일괄 지급 처리 대상 정산내역 아이디 목록
     * @param  string|null  $completedAt  날짜를 나타내는 문자열로, `yyyy-MM-dd` 형식을 따릅니다.
     * @param  bool|null  $isForTest  Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function completePlatformPayoutByPartnerSettlementIds(?bool $test = null, ?string $bulkPayoutId = null, ?string $name = null, ?array $partnerSettlementIds = null, ?string $completedAt = null, ?bool $isForTest = null): Model\CompletePlatformPayoutByPartnerSettlementIdsResponse
    {
        return $this->callOperationWithQueryAndBody('completePlatformPayoutByPartnerSettlementIds', 'POST', '/platform/partner-settlements/complete-payout', ['test' => $test], ['bulkPayoutId' => $bulkPayoutId, 'name' => $name, 'partnerSettlementIds' => $partnerSettlementIds, 'completedAt' => $completedAt, 'isForTest' => $isForTest], Model\CompletePlatformPayoutByPartnerSettlementIdsResponse::class);
    }

    /**
     * 일괄 지급 완료 처리 기능입니다.
     * 선택한 정산내역 아이디들로 일괄 지급을 완료 처리 합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  string|null  $bulkPayoutId  일괄 지급 아이디
     * @param  string|null  $name  일괄 지급 이름
     * @param  array<string, mixed>|null  $partnerSettlementIds  일괄 지급 처리 대상 정산내역 아이디 목록
     * @param  string|null  $completedAt  날짜를 나타내는 문자열로, `yyyy-MM-dd` 형식을 따릅니다.
     * @param  bool|null  $isForTest  Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function completePlatformPayoutByPartnerSettlementIdsAsync(?bool $test = null, ?string $bulkPayoutId = null, ?string $name = null, ?array $partnerSettlementIds = null, ?string $completedAt = null, ?bool $isForTest = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('completePlatformPayoutByPartnerSettlementIds', 'POST', '/platform/partner-settlements/complete-payout', ['test' => $test], ['bulkPayoutId' => $bulkPayoutId, 'name' => $name, 'partnerSettlementIds' => $partnerSettlementIds, 'completedAt' => $completedAt, 'isForTest' => $isForTest], Model\CompletePlatformPayoutByPartnerSettlementIdsResponse::class);
    }

    /**
     * 지급 내역 다건 조회 기능입니다.
     * 여러 지급 내역을 조회합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  bool|null  $isForTest  Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  지급 내역 필터 입력 정보
     */
    public function getPlatformPayouts(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Model\GetPlatformPayoutsResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformPayouts', 'GET', '/platform/payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformPayoutsResponse::class);
    }

    /**
     * 지급 내역 다건 조회 기능입니다.
     * 여러 지급 내역을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  bool|null  $isForTest  Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  지급 내역 필터 입력 정보
     */
    public function getPlatformPayoutsAsync(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformPayouts', 'GET', '/platform/payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformPayoutsResponse::class);
    }
}
