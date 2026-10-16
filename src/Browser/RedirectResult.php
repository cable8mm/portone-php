<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Browser;

/**
 * 브라우저 SDK 리다이렉트 결과를 타입으로 나타냅니다.
 *
 * 리다이렉트 방식에서 결제창 작업이 끝나면 redirectUrl로
 * paymentId(공통), code/message(실패 시), pgCode/pgMessage(PG 오류 존재 시)가
 * 쿼리 문자열로 전달됩니다.
 */
final class RedirectResult
{
    /**
     * RedirectResult 객체를 초기화합니다.
     */
    public function __construct(
        public readonly string $paymentId,
        public readonly ?string $code = null,
        public readonly ?string $message = null,
        public readonly ?string $pgCode = null,
        public readonly ?string $pgMessage = null,
    ) {}

    /**
     * 리다이렉트 쿼리 배열로 RedirectResult 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $query
     */
    public static function fromQuery(array $query): self
    {
        $paymentId = $query['paymentId'] ?? null;
        if (! is_string($paymentId) || $paymentId === '') {
            throw new \InvalidArgumentException('Redirect query must contain a non-empty paymentId string.');
        }

        return new self(
            $paymentId,
            self::optionalQueryString($query, 'code'),
            self::optionalQueryString($query, 'message'),
            self::optionalQueryString($query, 'pgCode'),
            self::optionalQueryString($query, 'pgMessage'),
        );
    }

    /**
     * 결제 과정에서 오류가 발생했는지 보고합니다.
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
            throw new \InvalidArgumentException('Redirect query field '.$field.' must be a string or null.');
        }

        return $query[$field];
    }
}
