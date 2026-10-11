<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

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
    protected static function requireObject(array $data, string $field, string $response): array
    {
        if (! is_array($data[$field] ?? null)) {
            throw new \UnexpectedValueException($response.' must contain an '.$field.' object.');
        }

        return $data[$field];
    }

    /** @return list<array<string,mixed>> */
    protected static function requireObjectList(array $data, string $field, string $response): array
    {
        $value = $data[$field] ?? null;
        if (! is_array($value) || ! array_is_list($value) || array_filter($value, 'is_array') !== $value) {
            throw new \UnexpectedValueException($response.' must contain a list of '.$field.' objects.');
        }

        return $value;
    }

    /** @return list<array<string,mixed>>|null */
    protected static function optionalObjectList(array $data, string $field, string $response): ?array
    {
        if (! array_key_exists($field, $data) || $data[$field] === null) {
            return null;
        }

        return self::requireObjectList($data, $field, $response);
    }
}
