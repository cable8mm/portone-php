<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

class OperationResponse
{
    /** @param array<string,mixed> $data */
    public function __construct(public readonly array $data) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }

    /** @return array<string,mixed> */
    public static function requireObject(array $data, string $field, string $response): array
    {
        if (! is_array($data[$field] ?? null)) {
            throw new \UnexpectedValueException($response.' must contain an '.$field.' object.');
        }

        return $data[$field];
    }

    /** @return array<string,mixed>|null */
    public static function optionalObject(array $data, string $field, string $response): ?array
    {
        if (! array_key_exists($field, $data) || $data[$field] === null) {
            return null;
        }

        return self::requireObject($data, $field, $response);
    }

    /** @return list<array<string,mixed>> */
    public static function requireObjectList(array $data, string $field, string $response): array
    {
        $value = $data[$field] ?? null;
        if (! is_array($value) || ! array_is_list($value) || array_filter($value, 'is_array') !== $value) {
            throw new \UnexpectedValueException($response.' must contain a list of '.$field.' objects.');
        }

        return $value;
    }

    /** @return list<array<string,mixed>>|null */
    public static function optionalObjectList(array $data, string $field, string $response): ?array
    {
        if (! array_key_exists($field, $data) || $data[$field] === null) {
            return null;
        }

        return self::requireObjectList($data, $field, $response);
    }

    /** @return array<string,mixed>|null */
    public static function optionalNonNullableObject(array $data, string $field, string $response): ?array
    {
        if (! array_key_exists($field, $data)) {
            return null;
        }

        return self::requireObject($data, $field, $response);
    }

    /** @return list<array<string,mixed>>|null */
    public static function optionalNonNullableObjectList(array $data, string $field, string $response): ?array
    {
        if (! array_key_exists($field, $data)) {
            return null;
        }

        return self::requireObjectList($data, $field, $response);
    }

    /**
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

    /** @return list<string> */
    public static function requireStringList(array $data, string $field, string $response): array
    {
        $value = $data[$field] ?? null;
        if (! is_array($value) || ! array_is_list($value) || array_filter($value, 'is_string') !== $value) {
            throw new \UnexpectedValueException($response.' must contain a list of '.$field.' strings.');
        }

        return $value;
    }

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

    public static function requireString(array $data, string $field, string $response): string
    {
        if (! is_string($data[$field] ?? null)) {
            throw new \UnexpectedValueException($response.' must contain a '.$field.' string.');
        }

        return $data[$field];
    }

    public static function requireBool(array $data, string $field, string $response): bool
    {
        if (! is_bool($data[$field] ?? null)) {
            throw new \UnexpectedValueException($response.' must contain a '.$field.' boolean.');
        }

        return $data[$field];
    }

    public static function requireInt(array $data, string $field, string $response): int
    {
        if (! is_int($data[$field] ?? null)) {
            throw new \UnexpectedValueException($response.' must contain a '.$field.' integer.');
        }

        return $data[$field];
    }

    /** @return list<int> */
    public static function requireIntList(array $data, string $field, string $response): array
    {
        $value = $data[$field] ?? null;
        if (! is_array($value) || ! array_is_list($value) || array_filter($value, 'is_int') !== $value) {
            throw new \UnexpectedValueException($response.' must contain a list of '.$field.' integers.');
        }

        return $value;
    }
}
