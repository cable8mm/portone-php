<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class PromotionClient extends AbstractClient
{
    public function getPromotion(?string $promotionId = null): Response\Promotion
    {
        return $this->callOperation('getPromotion', 'GET', '/promotions/{promotionId}', ['promotionId' => $promotionId], Response\Promotion::class, false);
    }

    public function getPromotionAsync(?string $promotionId = null): Future
    {
        return $this->callOperationAsync('getPromotion', 'GET', '/promotions/{promotionId}', ['promotionId' => $promotionId], Response\Promotion::class, false);
    }
}
