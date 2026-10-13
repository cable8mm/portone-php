<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 플랫폼 계좌 API 작업을 제공합니다.
 */
final class AccountClient extends AbstractClient
{
    /**
     * 예금주 조회 기능입니다.
     * 계좌의 예금주를 조회합니다.
     */
    public function getPlatformAccountHolder(?string $bank = null, ?string $accountNumber = null, ?bool $test = null, ?string $birthdate = null, ?string $businessRegistrationNumber = null): Model\PlatformAccountHolder
    {
        return $this->callOperation('getPlatformAccountHolder', 'GET', '/platform/bank-accounts/{bank}/{accountNumber}/holder', ['bank' => $bank, 'accountNumber' => $accountNumber, 'test' => $test, 'birthdate' => $birthdate, 'businessRegistrationNumber' => $businessRegistrationNumber], Model\PlatformAccountHolder::class, false);
    }

    /**
     * 예금주 조회 기능입니다.
     * 계좌의 예금주를 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPlatformAccountHolderAsync(?string $bank = null, ?string $accountNumber = null, ?bool $test = null, ?string $birthdate = null, ?string $businessRegistrationNumber = null): Future
    {
        return $this->callOperationAsync('getPlatformAccountHolder', 'GET', '/platform/bank-accounts/{bank}/{accountNumber}/holder', ['bank' => $bank, 'accountNumber' => $accountNumber, 'test' => $test, 'birthdate' => $birthdate, 'businessRegistrationNumber' => $businessRegistrationNumber], Model\PlatformAccountHolder::class, false);
    }
}
