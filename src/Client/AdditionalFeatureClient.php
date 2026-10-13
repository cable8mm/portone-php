<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 추가 결제 기능 API 작업을 제공합니다.
 */
final class AdditionalFeatureClient extends AbstractClient
{
    /**
     * PG사 카드 프로모션 조회 API 기능입니다.
     * 주어진 채널에 대해 PG사에서 제공하는 카드 프로모션 목록을 조회합니다.
     * 해당 API는 현재 특정 PG사(KCP_V2)에 대해서만 지원되며, 지원 여부는 포트원 기술지원팀에 문의 부탁드립니다.
     *
     * @param  string|null  $channelKey  채널 키: 조회하고자 하는 채널의 키
     * @param  int|null  $amount  결제 금액입니다. 해당 결제 금액 기준 이용 가능한 프로모션 목록이 조회됩니다.
     * @param  string|null  $cardCompany  조회할 카드사입니다. 값을 입력하지 않으면 카드사 필터링이 적용되지 않습니다.
     */
    public function getPgCardPromotions(?string $channelKey = null, ?int $amount = null, ?string $cardCompany = null): Model\GetPgCardPromotionsResponse
    {
        return $this->callOperation('getPgCardPromotions', 'GET', '/payment-gateways/card-promotion', ['channelKey' => $channelKey, 'amount' => $amount, 'cardCompany' => $cardCompany], Model\GetPgCardPromotionsResponse::class, false);
    }

    /**
     * PG사 카드 프로모션 조회 API 기능입니다.
     * 주어진 채널에 대해 PG사에서 제공하는 카드 프로모션 목록을 조회합니다.
     * 해당 API는 현재 특정 PG사(KCP_V2)에 대해서만 지원되며, 지원 여부는 포트원 기술지원팀에 문의 부탁드립니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     *
     * @param  string|null  $channelKey  채널 키: 조회하고자 하는 채널의 키
     * @param  int|null  $amount  결제 금액입니다. 해당 결제 금액 기준 이용 가능한 프로모션 목록이 조회됩니다.
     * @param  string|null  $cardCompany  조회할 카드사입니다. 값을 입력하지 않으면 카드사 필터링이 적용되지 않습니다.
     */
    public function getPgCardPromotionsAsync(?string $channelKey = null, ?int $amount = null, ?string $cardCompany = null): Future
    {
        return $this->callOperationAsync('getPgCardPromotions', 'GET', '/payment-gateways/card-promotion', ['channelKey' => $channelKey, 'amount' => $amount, 'cardCompany' => $cardCompany], Model\GetPgCardPromotionsResponse::class, false);
    }
}
