<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 공통 API 작업을 제공합니다.
 */
final class CommonClient extends AbstractClient
{
    /**
     * 은행 정보 조회 기능입니다.
     * 은행의 이름 등 정보를 조회합니다. 사용자에게 한국어 명칭을 제공하는 등의 용도로 사용하실 수 있습니다.
     */
    public function getBankInfos(): Model\GetBankInfosResponse
    {
        return $this->callOperation('getBankInfos', 'GET', '/banks', [], Model\GetBankInfosResponse::class, false);
    }

    /**
     * 은행 정보 조회 기능입니다.
     * 은행의 이름 등 정보를 조회합니다. 사용자에게 한국어 명칭을 제공하는 등의 용도로 사용하실 수 있습니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getBankInfosAsync(): Future
    {
        return $this->callOperationAsync('getBankInfos', 'GET', '/banks', [], Model\GetBankInfosResponse::class, false);
    }
}
