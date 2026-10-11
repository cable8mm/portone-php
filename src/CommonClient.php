<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class CommonClient extends AbstractClient
{
    public function getBankInfos(): Response\GetBankInfosResponse
    {
        return $this->callOperation('getBankInfos', 'GET', '/banks', [], Response\GetBankInfosResponse::class, false);
    }

    public function getBankInfosAsync(): Future
    {
        return $this->callOperationAsync('getBankInfos', 'GET', '/banks', [], Response\GetBankInfosResponse::class, false);
    }
}
