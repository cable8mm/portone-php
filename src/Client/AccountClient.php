<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

final class AccountClient extends AbstractClient
{
    public function getPlatformAccountHolder(?string $bank = null, ?string $accountNumber = null, ?bool $test = null, ?string $birthdate = null, ?string $businessRegistrationNumber = null): Model\PlatformAccountHolder
    {
        return $this->callOperation('getPlatformAccountHolder', 'GET', '/platform/bank-accounts/{bank}/{accountNumber}/holder', ['bank' => $bank, 'accountNumber' => $accountNumber, 'test' => $test, 'birthdate' => $birthdate, 'businessRegistrationNumber' => $businessRegistrationNumber], Model\PlatformAccountHolder::class, false);
    }

    public function getPlatformAccountHolderAsync(?string $bank = null, ?string $accountNumber = null, ?bool $test = null, ?string $birthdate = null, ?string $businessRegistrationNumber = null): Future
    {
        return $this->callOperationAsync('getPlatformAccountHolder', 'GET', '/platform/bank-accounts/{bank}/{accountNumber}/holder', ['bank' => $bank, 'accountNumber' => $accountNumber, 'test' => $test, 'birthdate' => $birthdate, 'businessRegistrationNumber' => $businessRegistrationNumber], Model\PlatformAccountHolder::class, false);
    }
}
