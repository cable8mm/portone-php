<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API의 본인인증 내역을 나타내는 모델입니다.
 */
final class IdentityVerification extends DiscriminatedResponse
{
    /**
     * 배열 형식의 API 응답 데이터로 IdentityVerification 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        [$variant, $known] = self::decodeVariant($data, 'status', ['FAILED', 'READY', 'VERIFIED']);

        if ($known) {
            self::requireFields($data, match ($variant) {
                'FAILED' => ['status', 'id', 'requestedCustomer', 'requestedAt', 'updatedAt', 'statusChangedAt', 'failure', 'version'],
                'READY' => ['status', 'id', 'requestedCustomer', 'requestedAt', 'updatedAt', 'statusChangedAt', 'version'],
                default => ['status', 'id', 'verifiedCustomer', 'requestedAt', 'updatedAt', 'statusChangedAt', 'verifiedAt', 'pgTxId', 'pgRawResponse', 'version'],
            });
        }

        return new self($data, $variant, $known);
    }
}
