<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 사업자 정보 관련 API 작업을 제공합니다.
 */
final class CompanyClient extends AbstractClient
{
    /**
     * 사업자등록 정보 조회 기능입니다.
     * 요청된 사업자등록번호 리스트에 해당하는 사업자등록 정보를 조회합니다.
     * 해당 API 사용을 위해서는 별도 문의가 필요합니다.
     *
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  array<string, mixed>|null  $brnList  조회할 사업자등록번호 리스트
     */
    public function getB2bBusinessInfos(?bool $test = null, ?array $brnList = null): Model\GetB2bBusinessInfosResponse
    {
        return $this->callOperationWithQueryAndBody('getB2bBusinessInfos', 'POST', '/b2b/companies/business-info', ['test' => $test], ['brnList' => $brnList], Model\GetB2bBusinessInfosResponse::class);
    }

    /**
     * 사업자등록 정보 조회 기능입니다.
     * 요청된 사업자등록번호 리스트에 해당하는 사업자등록 정보를 조회합니다.
     * 해당 API 사용을 위해서는 별도 문의가 필요합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  bool|null  $test  테스트 모드 여부: true 이면 테스트 모드로 실행되며, false 이거나 주어지지 않은 경우 테스트 모드를 사용하지 않습니다.
     * @param  array<string, mixed>|null  $brnList  조회할 사업자등록번호 리스트
     */
    public function getB2bBusinessInfosAsync(?bool $test = null, ?array $brnList = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('getB2bBusinessInfos', 'POST', '/b2b/companies/business-info', ['test' => $test], ['brnList' => $brnList], Model\GetB2bBusinessInfosResponse::class);
    }

    /**
     * 사업자 조회 기능입니다.
     * 사업자 정보를 조회합니다. 포트원 서비스에 연동 및 등록되지 않은 사업자도 조회 가능합니다.
     *
     * @param  string|null  $businessRegistrationNumber  사업자등록번호
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function getPlatformCompanyState(?string $businessRegistrationNumber = null, ?bool $test = null): Model\GetPlatformCompanyStatePayload
    {
        return $this->callOperation('getPlatformCompanyState', 'GET', '/platform/companies/{businessRegistrationNumber}/state', ['businessRegistrationNumber' => $businessRegistrationNumber, 'test' => $test], Model\GetPlatformCompanyStatePayload::class, false);
    }

    /**
     * 사업자 조회 기능입니다.
     * 사업자 정보를 조회합니다. 포트원 서비스에 연동 및 등록되지 않은 사업자도 조회 가능합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $businessRegistrationNumber  사업자등록번호
     * @param  bool|null  $test  테스트 모드 여부를 결정합니다. true 이면 테스트 모드로 실행됩니다. Request Body에도 isForTest가 있을 수 있으나, 둘 다 제공되면 Query Parameter의 test 값을 사용하고, Request Body의 isForTest는 무시됩니다. Query Parameter의 test와 Request Body의 isForTest에 모두 값이 제공되지 않으면 기본값인 false로 적용됩니다.
     */
    public function getPlatformCompanyStateAsync(?string $businessRegistrationNumber = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformCompanyState', 'GET', '/platform/companies/{businessRegistrationNumber}/state', ['businessRegistrationNumber' => $businessRegistrationNumber, 'test' => $test], Model\GetPlatformCompanyStatePayload::class, false);
    }
}
