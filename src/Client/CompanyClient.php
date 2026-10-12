<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

final class CompanyClient extends AbstractClient
{
    public function getB2bBusinessInfos(?bool $test = null, ?array $brnList = null): Model\GetB2bBusinessInfosResponse
    {
        return $this->callOperationWithQueryAndBody('getB2bBusinessInfos', 'POST', '/b2b/companies/business-info', ['test' => $test], ['brnList' => $brnList], Model\GetB2bBusinessInfosResponse::class);
    }

    public function getB2bBusinessInfosAsync(?bool $test = null, ?array $brnList = null): Future
    {
        return $this->callOperationWithQueryAndBodyAsync('getB2bBusinessInfos', 'POST', '/b2b/companies/business-info', ['test' => $test], ['brnList' => $brnList], Model\GetB2bBusinessInfosResponse::class);
    }

    public function getPlatformCompanyState(?string $businessRegistrationNumber = null, ?bool $test = null): Model\GetPlatformCompanyStatePayload
    {
        return $this->callOperation('getPlatformCompanyState', 'GET', '/platform/companies/{businessRegistrationNumber}/state', ['businessRegistrationNumber' => $businessRegistrationNumber, 'test' => $test], Model\GetPlatformCompanyStatePayload::class, false);
    }

    public function getPlatformCompanyStateAsync(?string $businessRegistrationNumber = null, ?bool $test = null): Future
    {
        return $this->callOperationAsync('getPlatformCompanyState', 'GET', '/platform/companies/{businessRegistrationNumber}/state', ['businessRegistrationNumber' => $businessRegistrationNumber, 'test' => $test], Model\GetPlatformCompanyStatePayload::class, false);
    }
}
