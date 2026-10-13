<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 거래처 생성 응답 정보를 나타내는 모델입니다.
 */
final class CreateB2bCounterpartyResponse extends OperationResponse
{
    /**
     * CreateB2bCounterpartyResponse 객체를 초기화합니다.
     */
    public function __construct(public readonly array $counterparty) {}

    /**
     * 배열 형식의 API 응답 데이터로 CreateB2bCounterpartyResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['counterparty'] ?? null)) {
            throw new \UnexpectedValueException('CreateB2bCounterpartyResponse must contain a counterparty object.');
        }

        return new self($data['counterparty']);
    }
}
