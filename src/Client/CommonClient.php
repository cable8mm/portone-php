<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

final class CommonClient extends AbstractClient
{
    public function getBankInfos(): Model\GetBankInfosResponse
    {
        return $this->callOperation('getBankInfos', 'GET', '/banks', [], Model\GetBankInfosResponse::class, false);
    }

    public function getBankInfosAsync(): Future
    {
        return $this->callOperationAsync('getBankInfos', 'GET', '/banks', [], Model\GetBankInfosResponse::class, false);
    }
}
