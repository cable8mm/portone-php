<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

/**
 * 프로모션 API 작업을 제공합니다.
 */
final class PromotionClient extends AbstractClient
{
    /**
     * 프로모션 단건 조회 기능입니다.
     * 주어진 아이디에 대응되는 프로모션을 조회합니다.
     */
    public function getPromotion(?string $promotionId = null): Model\Promotion
    {
        return $this->callOperation('getPromotion', 'GET', '/promotions/{promotionId}', ['promotionId' => $promotionId], Model\Promotion::class, false);
    }

    /**
     * 프로모션 단건 조회 기능입니다.
     * 주어진 아이디에 대응되는 프로모션을 조회합니다.
     * 비동기 요청을 시작하며, 반환된 Future에서 결과를 기다릴 수 있습니다.
     */
    public function getPromotionAsync(?string $promotionId = null): Future
    {
        return $this->callOperationAsync('getPromotion', 'GET', '/promotions/{promotionId}', ['promotionId' => $promotionId], Model\Promotion::class, false);
    }
}
