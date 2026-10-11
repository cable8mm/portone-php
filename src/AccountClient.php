<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class AccountClient extends AbstractClient
{
    public function getPlatformAccountHolder(?string $bank = null, ?string $accountNumber = null, ?bool $test = null, ?string $birthdate = null, ?string $businessRegistrationNumber = null): Response\PlatformAccountHolder
    {
        return $this->callOperation('getPlatformAccountHolder', 'GET', '/platform/bank-accounts/{bank}/{accountNumber}/holder', ['bank' => $bank, 'accountNumber' => $accountNumber, 'test' => $test, 'birthdate' => $birthdate, 'businessRegistrationNumber' => $businessRegistrationNumber], Response\PlatformAccountHolder::class, false);
    }

    public function getPlatformAccountHolderAsync(?string $bank = null, ?string $accountNumber = null, ?bool $test = null, ?string $birthdate = null, ?string $businessRegistrationNumber = null): Future
    {
        return $this->callOperationAsync('getPlatformAccountHolder', 'GET', '/platform/bank-accounts/{bank}/{accountNumber}/holder', ['bank' => $bank, 'accountNumber' => $accountNumber, 'test' => $test, 'birthdate' => $birthdate, 'businessRegistrationNumber' => $businessRegistrationNumber], Response\PlatformAccountHolder::class, false);
    }
}
