<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Browser;

/**
 * 브라우저 SDK 빌링키 발급 리다이렉트 결과를 타입으로 나타냅니다.
 *
 * 발급 성공 시 redirectUrl 쿼리에는 billingKey만 전달됩니다.
 * 발급 실패 시에는 billingKey, code, message, pgCode, pgMessage가 전달되지만,
 * 이때의 billingKey는 발급되지 않은 값이므로 billingKey를 null로 둡니다.
 */
final class BillingKeyRedirectResult
{
    /**
     * BillingKeyRedirectResult 객체를 초기화합니다.
     */
    public function __construct(
        public readonly ?string $billingKey,
        public readonly ?string $code = null,
        public readonly ?string $message = null,
        public readonly ?string $pgCode = null,
        public readonly ?string $pgMessage = null,
    ) {}

    /**
     * 빌링키 발급 리다이렉트 쿼리 배열로 BillingKeyRedirectResult 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $query
     */
    public static function fromQuery(array $query): self
    {
        $code = self::optionalQueryString($query, 'code');
        $message = self::optionalQueryString($query, 'message');
        $pgCode = self::optionalQueryString($query, 'pgCode');
        $pgMessage = self::optionalQueryString($query, 'pgMessage');

        if ($code !== null) {
            // A failure query carries a billingKey that was never issued.
            return new self(null, $code, $message, $pgCode, $pgMessage);
        }

        $billingKey = $query['billingKey'] ?? null;
        if (! is_string($billingKey) || $billingKey === '') {
            throw new \InvalidArgumentException('Billing-key redirect query without code must contain a non-empty billingKey string.');
        }

        return new self($billingKey, null, $message, $pgCode, $pgMessage);
    }

    /**
     * 빌링키 발급 과정에서 오류가 발생했는지 보고합니다.
     */
    public function isFailure(): bool
    {
        return $this->code !== null;
    }

    /**
     * @param  array<string,mixed>  $query
     */
    private static function optionalQueryString(array $query, string $field): ?string
    {
        if (! array_key_exists($field, $query) || $query[$field] === null) {
            return null;
        }

        if (! is_string($query[$field])) {
            throw new \InvalidArgumentException('Billing-key redirect query field '.$field.' must be a string or null.');
        }

        return $query[$field];
    }
}
