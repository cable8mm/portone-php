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
해당 API 사용을 위해서는 별도 문의가 필요합니다.
     */
    public function getB2bBusinessInfos(?bool $test = null, ?array $brnList = null): Model\GetB2bBusinessInfosResponse
    {
        return $this->callOperationWithQueryAndBody('getB2bBusinessInfos', 'POST', '/b2b/companies/business-info', ['test' => $test], ['brnList' => $brnList], Model\GetB2bBusinessInfosResponse::class);
    }

    /**
     * 사업자등록 정보 조회 기능입니다.
     * 요청된 사업자등록번호 리스트에 해당하는 사업자등록 정보를 조회합니다.
해당 API 사용을 위해서는 별도 문의가 필요합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getB2bBusinessInfosAsync(?bool $test = null, ?array $brnList = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('getB2bBusinessInfos', 'POST', '/b2b/companies/business-info', ['test' => $test], ['brnList' => $brnList], Model\GetB2bBusinessInfosResponse::class);
    }

    /**
     * 사업자 조회 기능입니다.
     * 사업자 정보를 조회합니다. 포트원 서비스에 연동 및 등록되지 않은 사업자도 조회 가능합니다.
     */
    public function getPlatformCompanyState(?string $businessRegistrationNumber = null, ?bool $test = null): Model\GetPlatformCompanyStatePayload
    {
        return $this->callOperation('getPlatformCompanyState', 'GET', '/platform/companies/{businessRegistrationNumber}/state', ['businessRegistrationNumber' => $businessRegistrationNumber, 'test' => $test], Model\GetPlatformCompanyStatePayload::class, false);
    }

    /**
     * 사업자 조회 기능입니다.
     * 사업자 정보를 조회합니다. 포트원 서비스에 연동 및 등록되지 않은 사업자도 조회 가능합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformCompanyStateAsync(?string $businessRegistrationNumber = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformCompanyState', 'GET', '/platform/companies/{businessRegistrationNumber}/state', ['businessRegistrationNumber' => $businessRegistrationNumber, 'test' => $test], Model\GetPlatformCompanyStatePayload::class, false);
    }
}
