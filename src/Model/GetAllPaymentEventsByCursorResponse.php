<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 결제 이벤트 커서 기반 대용량 다건 조회 성공 응답 정보를 나타내는 모델입니다.
 */
final class GetAllPaymentEventsByCursorResponse extends OperationResponse
{
    /**
     * GetAllPaymentEventsByCursorResponse 객체를 초기화합니다.
     *
     * @param  list<PaymentEvent>  $items
     */
    public function __construct(public readonly array $items) {}

    /**
     * 배열 형식의 API 응답 데이터로 GetAllPaymentEventsByCursorResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        $items = self::requireObjectList($data, 'items', self::class);

        return new self(self::mapObjectList(
            $items,
            static fn (array $item): PaymentEvent => PaymentEvent::fromArray($item),
        ));
    }
}
