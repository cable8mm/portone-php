<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 현금영수증 내역을 나타내는 모델입니다.
 */
final class CashReceipt extends DiscriminatedResponse
{
    /**
     * 배열 형식의 API 응답 데이터로 CashReceipt 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'status', ['CANCELLED', 'ISSUED', 'ISSUE_FAILED']);

        if ($known) {
            self::requireFields($data, match ($variant) {
                'CANCELLED' => ['status', 'merchantId', 'storeId', 'paymentId', 'channel', 'amount', 'currency', 'orderName', 'isManual', 'issueNumber', 'issuedAt', 'cancelledAt'],
                'ISSUE_FAILED' => ['status', 'merchantId', 'storeId', 'paymentId', 'orderName', 'isManual'],
                default => ['status', 'merchantId', 'storeId', 'paymentId', 'channel', 'amount', 'currency', 'orderName', 'isManual', 'issueNumber', 'issuedAt'],
            });
        }

        return new self($data, $variant, $known);
    }
}
