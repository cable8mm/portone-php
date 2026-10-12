<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

final class PromotionClient extends AbstractClient
{
    public function getPromotion(?string $promotionId = null): Model\Promotion
    {
        return $this->callOperation('getPromotion', 'GET', '/promotions/{promotionId}', ['promotionId' => $promotionId], Model\Promotion::class, false);
    }

    public function getPromotionAsync(?string $promotionId = null): Future
    {
        return $this->callOperationAsync('getPromotion', 'GET', '/promotions/{promotionId}', ['promotionId' => $promotionId], Model\Promotion::class, false);
    }
}
