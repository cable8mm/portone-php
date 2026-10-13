<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 웹훅 응답 정보를 나타내는 모델입니다.
 */
final class PaymentWebhookResponse extends OperationResponse
{
    /**
     * PaymentWebhookResponse 객체를 초기화합니다.
     */
    public function __construct(
        public readonly string $code,
        public readonly string $header,
        public readonly string $body,
        public readonly string $respondedAt,
    ) {}

    /**
     * 배열 형식의 API 응답 데이터로 PaymentWebhookResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        foreach (['code', 'header', 'body', 'respondedAt'] as $field) {
            if (! is_string($data[$field] ?? null)) {
                throw new \UnexpectedValueException('PaymentWebhookResponse must contain string '.$field.'.');
            }
        }

        return new self($data['code'], $data['header'], $data['body'], $data['respondedAt']);
    }
}
