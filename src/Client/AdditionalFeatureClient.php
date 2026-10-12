<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

final class AdditionalFeatureClient extends AbstractClient
{
    public function getPgCardPromotions(?string $channelKey = null, ?int $amount = null, ?string $cardCompany = null): Model\GetPgCardPromotionsResponse
    {
        return $this->callOperation('getPgCardPromotions', 'GET', '/payment-gateways/card-promotion', ['channelKey' => $channelKey, 'amount' => $amount, 'cardCompany' => $cardCompany], Model\GetPgCardPromotionsResponse::class, false);
    }

    public function getPgCardPromotionsAsync(?string $channelKey = null, ?int $amount = null, ?string $cardCompany = null): Future
    {
        return $this->callOperationAsync('getPgCardPromotions', 'GET', '/payment-gateways/card-promotion', ['channelKey' => $channelKey, 'amount' => $amount, 'cardCompany' => $cardCompany], Model\GetPgCardPromotionsResponse::class, false);
    }
}
