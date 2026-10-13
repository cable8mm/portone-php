<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 웹훅 재발송 응답 정보를 나타내는 모델입니다.
 */
final class ResendWebhookResponse extends OperationResponse
{
    /**
     * ResendWebhookResponse 객체를 초기화합니다.
     *
     * @param  array<string,mixed>  $webhook
     */
    public function __construct(public readonly array $webhook) {}

    /**
     * 배열 형식의 API 응답 데이터로 ResendWebhookResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['webhook'] ?? null)) {
            throw new \UnexpectedValueException('ResendWebhookResponse must contain a webhook object.');
        }

        return new self($data['webhook']);
    }
}
