<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 에스크로 배송 정보 등록 성공 응답을 나타내는 모델입니다.
 */
final class ApplyEscrowLogisticsResponse extends OperationResponse
{
    /**
     * ApplyEscrowLogisticsResponse 객체를 초기화합니다.
     */
    public function __construct(
        public readonly string $invoiceNumber,
        public readonly string $sentAt,
        public readonly string $appliedAt,
    ) {}

    /**
     * 배열 형식의 API 응답 데이터로 ApplyEscrowLogisticsResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        foreach (['invoiceNumber', 'sentAt', 'appliedAt'] as $field) {
            if (! is_string($data[$field] ?? null)) {
                throw new \UnexpectedValueException('ApplyEscrowLogisticsResponse must contain string '.$field.'.');
            }
        }

        return new self($data['invoiceNumber'], $data['sentAt'], $data['appliedAt']);
    }
}
