<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class AccountClient extends AbstractClient
{
    public function getPlatformAccountHolder(mixed $bank = null, mixed $accountNumber = null, mixed $test = null, mixed $birthdate = null, mixed $businessRegistrationNumber = null): Response\PlatformAccountHolder
    {
        return $this->callOperation('getPlatformAccountHolder', 'GET', '/platform/bank-accounts/{bank}/{accountNumber}/holder', ['bank' => $bank, 'accountNumber' => $accountNumber, 'test' => $test, 'birthdate' => $birthdate, 'businessRegistrationNumber' => $businessRegistrationNumber], Response\PlatformAccountHolder::class, false);
    }

    public function getPlatformAccountHolderAsync(mixed $bank = null, mixed $accountNumber = null, mixed $test = null, mixed $birthdate = null, mixed $businessRegistrationNumber = null): Future
    {
        return $this->callOperationAsync('getPlatformAccountHolder', 'GET', '/platform/bank-accounts/{bank}/{accountNumber}/holder', ['bank' => $bank, 'accountNumber' => $accountNumber, 'test' => $test, 'birthdate' => $birthdate, 'businessRegistrationNumber' => $businessRegistrationNumber], Response\PlatformAccountHolder::class, false);
    }
}
