<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class AdditionalFeatureClient extends AbstractClient
{
    public function getPgCardPromotions(mixed $channelKey = null, mixed $amount = null, mixed $cardCompany = null): Response\GetPgCardPromotionsResponse
    {
        return $this->callOperation('getPgCardPromotions', 'GET', '/payment-gateways/card-promotion', ['channelKey' => $channelKey, 'amount' => $amount, 'cardCompany' => $cardCompany], Response\GetPgCardPromotionsResponse::class, false);
    }

    public function getPgCardPromotionsAsync(mixed $channelKey = null, mixed $amount = null, mixed $cardCompany = null): Future
    {
        return $this->callOperationAsync('getPgCardPromotions', 'GET', '/payment-gateways/card-promotion', ['channelKey' => $channelKey, 'amount' => $amount, 'cardCompany' => $cardCompany], Response\GetPgCardPromotionsResponse::class, false);
    }
}
