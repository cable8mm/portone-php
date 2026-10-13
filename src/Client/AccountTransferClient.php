<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 플랫폼 계좌 이체 API 작업을 제공합니다.
 */
final class AccountTransferClient extends AbstractClient
{
    /**
     * 이체 내역 다건 조회 기능입니다.
     * 여러 이체 내역을 조회합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  bool|null  $isForTest  Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  계좌 이체 조회 필터(이체 일시, 생성 일시, 상태 등)
     */
    public function getPlatformAccountTransfers(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Model\GetPlatformAccountTransfersResponse
    {
        return $this->callOperationWithQueryRequestBody('getPlatformAccountTransfers', 'GET', '/platform/account-transfers', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformAccountTransfersResponse::class);
    }

    /**
     * 이체 내역 다건 조회 기능입니다.
     * 여러 이체 내역을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  bool|null  $isForTest  Query Parameter의 test에 값이 제공된 경우 Query Parameter의 test를 사용하고 해당 값은 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     * @param  array<string, mixed>|null  $page  다건 조회 API 에 사용되는 페이지 입력 정보
     * @param  array<string, mixed>|null  $filter  계좌 이체 조회 필터(이체 일시, 생성 일시, 상태 등)
     */
    public function getPlatformAccountTransfersAsync(?bool $test = null, ?bool $isForTest = null, ?array $page = null, ?array $filter = null): Future
    {
        return $this->callOperationWithQueryRequestBodyAsync('getPlatformAccountTransfers', 'GET', '/platform/account-transfers', ['test' => $test], ['isForTest' => $isForTest, 'page' => $page, 'filter' => $filter], Model\GetPlatformAccountTransfersResponse::class);
    }
}
