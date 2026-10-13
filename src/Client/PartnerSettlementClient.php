<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 플랫폼 파트너 정산 API 작업을 제공합니다.
 */
final class PartnerSettlementClient extends AbstractClient
{
    /**
     * 정산내역 삭제 기능입니다.
     * 선택한 정산내역들을 삭제합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $partnerSettlementIds  삭제할 정산내역 아이디 목록
     * @param  bool|null  $isForTest  Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function deletePlatformPartnerSettlements(?bool $test = null, ?array $partnerSettlementIds = null, ?bool $isForTest = null): Model\DeletePlatformPartnerSettlementsResponse
    {
        return $this->callOperationWithQueryAndBody('deletePlatformPartnerSettlements', 'POST', '/platform/partner-settlements/delete', ['test' => $test], ['partnerSettlementIds' => $partnerSettlementIds, 'isForTest' => $isForTest], Model\DeletePlatformPartnerSettlementsResponse::class);
    }

    /**
     * 정산내역 삭제 기능입니다.
     * 선택한 정산내역들을 삭제합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $partnerSettlementIds  삭제할 정산내역 아이디 목록
     * @param  bool|null  $isForTest  Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function deletePlatformPartnerSettlementsAsync(?bool $test = null, ?array $partnerSettlementIds = null, ?bool $isForTest = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('deletePlatformPartnerSettlements', 'POST', '/platform/partner-settlements/delete', ['test' => $test], ['partnerSettlementIds' => $partnerSettlementIds, 'isForTest' => $isForTest], Model\DeletePlatformPartnerSettlementsResponse::class);
    }

    /**
     * 정산 내역 다건 조회 기능입니다.
     * 여러 정산 내역을 조회합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  조회할 정산내역 조건 필터
     * @param  bool|null  $isForTest  테스트 모드 여부: Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function getPlatformPartnerSettlements(?bool $test = null, ?array $page = null, ?array $filter = null, ?bool $isForTest = null): Model\GetPlatformPartnerSettlementsResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformPartnerSettlements', 'GET', '/platform/partner-settlements', ['test' => $test], ['page' => $page, 'filter' => $filter, 'isForTest' => $isForTest], Model\GetPlatformPartnerSettlementsResponse::class);
    }

    /**
     * 정산 내역 다건 조회 기능입니다.
     * 여러 정산 내역을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  조회할 정산내역 조건 필터
     * @param  bool|null  $isForTest  테스트 모드 여부: Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function getPlatformPartnerSettlementsAsync(?bool $test = null, ?array $page = null, ?array $filter = null, ?bool $isForTest = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformPartnerSettlements', 'GET', '/platform/partner-settlements', ['test' => $test], ['page' => $page, 'filter' => $filter, 'isForTest' => $isForTest], Model\GetPlatformPartnerSettlementsResponse::class);
    }
}
