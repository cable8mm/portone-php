<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 빌링키 발급 실패 채널 응답을 나타내는 모델입니다.
 */
final class FailedPgBillingKeyIssueResponse extends OperationResponse
{
    /**
     * FailedPgBillingKeyIssueResponse 객체를 초기화합니다.
     *
     * @param  array<string, mixed>  $channel
     * @param  array<string, mixed>  $failure
     */
    public function __construct(
        private readonly array $channel,
        public readonly array $failure,
    ) {}

    /**
     * 배열 형식의 API 응답 데이터로 FailedPgBillingKeyIssueResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireObject($data, 'channel', self::class),
            self::requireObject($data, 'failure', self::class),
        );
    }

    /**
     * 응답에 포함된 결제 채널 정보를 반환합니다.
     *
     * @return array<string,mixed>
     */
    public function channel(): array
    {
        return $this->channel;
    }
}
