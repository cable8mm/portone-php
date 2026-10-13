<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

/**
 * PortOne V2 API 응답 데이터를 담는 기본 모델입니다.
 */
class OperationResponse
{
    /**
     * OperationResponse 객체를 초기화합니다.
     *
     * @param  array<string,mixed>  $data
     */
    public function __construct(public readonly array $data) {}

    /**
     * 배열 형식의 API 응답 데이터로 OperationResponse 객체를 생성합니다.
     *
     * @param  array<string,mixed>  $data
     * @return static 변환된 객체입니다.
     */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }

    /**
     * 지정한 필드가 객체 배열인지 확인하고 반환합니다.
     *
     * @return array<string,mixed>
     */
    public static function requireObject(array $data, string $field, string $response): array
    {
        if (! is_array($data[$field] ?? null)) {
            throw new \UnexpectedValueException($response.' must contain an '.$field.' object.');
        }

        return $data[$field];
    }

    /**
     * 지정한 필드가 없거나 null이면 null을 반환하고, 값이 있으면 객체 배열인지 확인해 반환합니다.
     *
     * @return array<string,mixed>|null
     */
    public static function optionalObject(array $data, string $field, string $response): ?array
    {
        if (! array_key_exists($field, $data) || $data[$field] === null) {
            return null;
        }

        return self::requireObject($data, $field, $response);
    }

    /**
     * 지정한 필드가 객체 배열의 목록인지 확인하고 반환합니다.
     *
     * @return list<array<string,mixed>>
     */
    public static function requireObjectList(array $data, string $field, string $response): array
    {
        $value = $data[$field] ?? null;
        if (! is_array($value) || ! array_is_list($value) || array_filter($value, 'is_array') !== $value) {
            throw new \UnexpectedValueException($response.' must contain a list of '.$field.' objects.');
        }

        return $value;
    }

    /**
     * 지정한 필드가 없거나 null이면 null을 반환하고, 값이 있으면 객체 배열 목록인지 확인해 반환합니다.
     *
     * @return list<array<string,mixed>>|null
     */
    public static function optionalObjectList(array $data, string $field, string $response): ?array
    {
        if (! array_key_exists($field, $data) || $data[$field] === null) {
            return null;
        }

        return self::requireObjectList($data, $field, $response);
    }

    /**
     * 지정한 필드가 없으면 null을 반환하고, 값이 있으면 객체 배열인지 확인해 반환합니다.
     *
     * @return array<string,mixed>|null
     */
    public static function optionalNonNullableObject(array $data, string $field, string $response): ?array
    {
        if (! array_key_exists($field, $data)) {
            return null;
        }

        return self::requireObject($data, $field, $response);
    }

    /**
     * 지정한 필드가 없으면 null을 반환하고, 값이 있으면 객체 배열 목록인지 확인해 반환합니다.
     *
     * @return list<array<string,mixed>>|null
     */
    public static function optionalNonNullableObjectList(array $data, string $field, string $response): ?array
    {
        if (! array_key_exists($field, $data)) {
            return null;
        }

        return self::requireObjectList($data, $field, $response);
    }

    /**
     * 객체 배열 목록의 각 항목에 변환 함수를 적용합니다.
     *
     * @template T of object
     *
     * @param  list<array<string, mixed>>  $items
     * @param  callable(array<string, mixed>): T  $factory
     * @return list<T>
     */
    public static function mapObjectList(array $items, callable $factory): array
    {
        return array_map($factory, $items);
    }

    /**
     * 지정한 필드가 문자열 목록인지 확인하고 반환합니다.
     *
     * @return list<string>
     */
    public static function requireStringList(array $data, string $field, string $response): array
    {
        $value = $data[$field] ?? null;
        if (! is_array($value) || ! array_is_list($value) || array_filter($value, 'is_string') !== $value) {
            throw new \UnexpectedValueException($response.' must contain a list of '.$field.' strings.');
        }

        return $value;
    }

    /**
     * 지정한 필드가 없거나 null이면 null을 반환하고, 값이 있으면 문자열인지 확인해 반환합니다.
     */
    public static function optionalString(array $data, string $field, string $response): ?string
    {
        if (! array_key_exists($field, $data) || $data[$field] === null) {
            return null;
        }

        if (! is_string($data[$field])) {
            throw new \UnexpectedValueException($response.' must contain a '.$field.' string or null.');
        }

        return $data[$field];
    }

    /**
     * 지정한 필드가 없으면 null을 반환하고, 값이 있으면 문자열인지 확인해 반환합니다.
     */
    public static function optionalNonNullableString(array $data, string $field, string $response): ?string
    {
        if (! array_key_exists($field, $data)) {
            return null;
        }

        if (! is_string($data[$field])) {
            throw new \UnexpectedValueException($response.' must contain a '.$field.' string when present.');
        }

        return $data[$field];
    }

    /**
     * 지정한 필드가 없으면 null을 반환하고, 값이 있으면 정수인지 확인해 반환합니다.
     */
    public static function optionalNonNullableInt(array $data, string $field, string $response): ?int
    {
        if (! array_key_exists($field, $data)) {
            return null;
        }
        if (! is_int($data[$field])) {
            throw new \UnexpectedValueException($response.' must contain a '.$field.' integer when present.');
        }

        return $data[$field];
    }

    /**
     * 지정한 필드가 없으면 null을 반환하고, 값이 있으면 불리언인지 확인해 반환합니다.
     */
    public static function optionalNonNullableBool(array $data, string $field, string $response): ?bool
    {
        if (! array_key_exists($field, $data)) {
            return null;
        }
        if (! is_bool($data[$field])) {
            throw new \UnexpectedValueException($response.' must contain a '.$field.' boolean when present.');
        }

        return $data[$field];
    }

    /**
     * 지정한 필드가 문자열인지 확인하고 반환합니다.
     */
    public static function requireString(array $data, string $field, string $response): string
    {
        if (! is_string($data[$field] ?? null)) {
            throw new \UnexpectedValueException($response.' must contain a '.$field.' string.');
        }

        return $data[$field];
    }

    /**
     * 지정한 필드가 불리언인지 확인하고 반환합니다.
     */
    public static function requireBool(array $data, string $field, string $response): bool
    {
        if (! is_bool($data[$field] ?? null)) {
            throw new \UnexpectedValueException($response.' must contain a '.$field.' boolean.');
        }

        return $data[$field];
    }

    /**
     * 지정한 필드가 정수인지 확인하고 반환합니다.
     */
    public static function requireInt(array $data, string $field, string $response): int
    {
        if (! is_int($data[$field] ?? null)) {
            throw new \UnexpectedValueException($response.' must contain a '.$field.' integer.');
        }

        return $data[$field];
    }

    /**
     * 지정한 필드가 정수 목록인지 확인하고 반환합니다.
     *
     * @return list<int>
     */
    public static function requireIntList(array $data, string $field, string $response): array
    {
        $value = $data[$field] ?? null;
        if (! is_array($value) || ! array_is_list($value) || array_filter($value, 'is_int') !== $value) {
            throw new \UnexpectedValueException($response.' must contain a list of '.$field.' integers.');
        }

        return $value;
    }
}
