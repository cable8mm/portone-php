<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class AdditionalFeatureClient extends AbstractClient
{
    public function getPgCardPromotions(?string $channelKey = null, ?int $amount = null, ?string $cardCompany = null): Response\GetPgCardPromotionsResponse
    {
        return $this->callOperation('getPgCardPromotions', 'GET', '/payment-gateways/card-promotion', ['channelKey' => $channelKey, 'amount' => $amount, 'cardCompany' => $cardCompany], Response\GetPgCardPromotionsResponse::class, false);
    }

    public function getPgCardPromotionsAsync(?string $channelKey = null, ?int $amount = null, ?string $cardCompany = null): Future
    {
        return $this->callOperationAsync('getPgCardPromotions', 'GET', '/payment-gateways/card-promotion', ['channelKey' => $channelKey, 'amount' => $amount, 'cardCompany' => $cardCompany], Response\GetPgCardPromotionsResponse::class, false);
    }
}
