<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 거래처 정보 수정 응답을 나타내는 모델입니다.
 */
final class UpdateB2bCounterpartyResponse extends OperationResponse
{
    /**
     * UpdateB2bCounterpartyResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly array $counterparty) {}

    /**
     * 배열 형식의 API 응답 데이터로 UpdateB2bCounterpartyResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['counterparty'] ?? null)) {
            throw new \UnexpectedValueException('UpdateB2bCounterpartyResponse must contain a counterparty object.');
        }

        return new self($data['counterparty']);
    }
}
