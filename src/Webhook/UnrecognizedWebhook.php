<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Webhook;

/**
 * 이 SDK가 알지 못하는 유형의 검증된 웹훅 본문을 보존합니다.
 */
final class UnrecognizedWebhook implements Webhook
{
    /**
     * 알 수 없는 유형의 웹훅에서 디코딩한 본문 데이터로 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $body
     */
    public function __construct(public readonly array $body) {}
}
