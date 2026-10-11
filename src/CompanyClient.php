<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class CompanyClient extends AbstractClient
{
    public function getB2bBusinessInfos(mixed $test = null, mixed $brnList = null): Response\GetB2bBusinessInfosResponse
    {
        return $this->callOperationWithQueryAndBody('getB2bBusinessInfos', 'POST', '/b2b/companies/business-info', ['test' => $test], ['brnList' => $brnList], Response\GetB2bBusinessInfosResponse::class);
    }

    public function getB2bBusinessInfosAsync(mixed $test = null, mixed $brnList = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('getB2bBusinessInfos', 'POST', '/b2b/companies/business-info', ['test' => $test], ['brnList' => $brnList], Response\GetB2bBusinessInfosResponse::class);
    }

    public function getPlatformCompanyState(mixed $businessRegistrationNumber = null, mixed $test = null): Response\GetPlatformCompanyStatePayload
    {
        return $this->callOperation('getPlatformCompanyState', 'GET', '/platform/companies/{businessRegistrationNumber}/state', ['businessRegistrationNumber' => $businessRegistrationNumber, 'test' => $test], Response\GetPlatformCompanyStatePayload::class, false);
    }

    public function getPlatformCompanyStateAsync(mixed $businessRegistrationNumber = null, mixed $test = null): Future
    {
        return $this->callOperationAsync('getPlatformCompanyState', 'GET', '/platform/companies/{businessRegistrationNumber}/state', ['businessRegistrationNumber' => $businessRegistrationNumber, 'test' => $test], Response\GetPlatformCompanyStatePayload::class, false);
    }
}
