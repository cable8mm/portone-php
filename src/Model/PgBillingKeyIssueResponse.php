<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 채널 별 빌링키 발급 응답을 나타내는 모델입니다.
 */
final class PgBillingKeyIssueResponse extends OperationResponse
{
    /**
     * PgBillingKeyIssueResponse 객체를 초기화합니다.
     *
     * @param  array<string,mixed>  $payload
     */
    public function __construct(
        public readonly array $channel,
        private readonly array $payload,
    ) {}

    /**
     * 배열 형식의 API 응답 데이터로 PgBillingKeyIssueResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self(is_array($data['channel'] ?? null) ? $data['channel'] : [], $data);
    }

    /**
     * 응답 데이터를 판별자에 해당하는 구체적인 응답 타입으로 변환합니다.
     *
     * @param  array<string,mixed>  $data
     */
    public static function decode(array $data): OperationResponse
    {
        return match ($data['type'] ?? null) {
            'FAILED' => FailedPgBillingKeyIssueResponse::fromArray($data),
            'ISSUED' => IssuedPgBillingKeyIssueResponse::fromArray($data),
            default => self::fromArray($data),
        };
    }

    /**
     * 응답의 원본 데이터 배열을 반환합니다.
     *
     * @return array<string,mixed>
     */
    public function payload(): array
    {
        return $this->payload;
    }
}
