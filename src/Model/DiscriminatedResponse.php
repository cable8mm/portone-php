<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * 판별자 값에 따라 유형이 달라지는 응답을 표현하며, 알 수 없는 유형의 데이터도 보존합니다.
 */
class DiscriminatedResponse extends OperationResponse
{
    /**
     * 원본 응답 데이터, 판별자 값 및 알려진 유형 여부로 응답 객체를 초기화합니다.
     *
     * @param  array<string,mixed>  $data
     */
    public function __construct(
        array $data,
        public readonly string $variant,
        public readonly bool $knownVariant,
    ) {
        parent::__construct($data);
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  list<string>  $knownVariants
     */
    protected static function decodeVariant(array $data, string $field, array $knownVariants): array
    {
        $variant = self::requireString($data, $field, static::class);

        return [$variant, in_array($variant, $knownVariants, true)];
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  list<string>  $required
     */
    protected static function requireFields(array $data, array $required): void
    {
        foreach ($required as $field) {
            if (! array_key_exists($field, $data)) {
                throw new \UnexpectedValueException(static::class.' must contain a '.$field.' field.');
            }
        }
    }
}
