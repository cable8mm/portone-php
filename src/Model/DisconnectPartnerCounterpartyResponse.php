<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 파트너 거래처 연동 해제 응답을 나타내는 모델입니다.
 */
final class DisconnectPartnerCounterpartyResponse extends OperationResponse
{
    /**
     * DisconnectPartnerCounterpartyResponse 객체를 초기화합니다.
     *
     * @param  array<string,mixed>  $data  디코딩된 응답 본문입니다.
     */
    public function __construct(public readonly array $partner, array $data = [])
    {
        parent::__construct($data);
    }

    /**
     * 배열 형식의 API 응답 데이터로 DisconnectPartnerCounterpartyResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new self(self::requireObject($data, 'partner', self::class), data: $data);
    }
}
