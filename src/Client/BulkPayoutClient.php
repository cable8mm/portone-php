<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 플랫폼 대량 지급 API 작업을 제공합니다.
 */
final class BulkPayoutClient extends AbstractClient
{
    /**
     * 일괄 지급 내역 다건 조회 기능입니다.
     * 성공 응답으로 조회된 일괄 지급 내역 리스트와 페이지 정보 및 상태 별 개수 정보를 반환합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  bool|null  $isForTest  Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  일괄 지급 조회 필터(상태, 지급 유형, 조회 조건)
     */
    public function getPlatformBulkPayouts(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Model\GetPlatformBulkPayoutsResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformBulkPayouts', 'GET', '/platform/bulk-payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformBulkPayoutsResponse::class);
    }

    /**
     * 일괄 지급 내역 다건 조회 기능입니다.
     * 성공 응답으로 조회된 일괄 지급 내역 리스트와 페이지 정보 및 상태 별 개수 정보를 반환합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  bool|null  $isForTest  Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  일괄 지급 조회 필터(상태, 지급 유형, 조회 조건)
     */
    public function getPlatformBulkPayoutsAsync(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformBulkPayouts', 'GET', '/platform/bulk-payouts', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformBulkPayoutsResponse::class);
    }
}
