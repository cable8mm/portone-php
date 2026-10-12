<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tools;

final class OpenApiDrift
{
    private const HTTP_METHODS = ['get', 'post', 'put', 'patch', 'delete'];

    /**
     * @return array{
     *     operations: array{added: list<array<string, string>>, removed: list<array<string, string>>, changed: list<array<string, mixed>>},
     *     schemas: array{added: list<string>, removed: list<string>, changed: list<array{name: string, fields: array<string, list<string>>, schemaPropertiesChanged: list<string>}>}
     * }
     */
    public static function compare(array $baseline, array $current): array
    {
        $beforeOperations = self::operations($baseline);
        $afterOperations = self::operations($current);
        $operationChanges = [
            'added' => [],
            'removed' => [],
            'changed' => [],
        ];

        foreach (array_diff(array_keys($afterOperations), array_keys($beforeOperations)) as $key) {
            $operationChanges['added'][] = $afterOperations[$key]['identity'];
        }
        foreach (array_diff(array_keys($beforeOperations), array_keys($afterOperations)) as $key) {
            $operationChanges['removed'][] = $beforeOperations[$key]['identity'];
        }
        foreach (array_intersect(array_keys($beforeOperations), array_keys($afterOperations)) as $key) {
            $before = $beforeOperations[$key];
            $after = $afterOperations[$key];
            $changedProperties = self::changedKeys($before['definition'], $after['definition']);
            if ($changedProperties !== []) {
                $operationChanges['changed'][] = [
                    ...$after['identity'],
                    'changes' => $changedProperties,
                ];
            }
        }

        $beforeSchemas = self::schemas($baseline);
        $afterSchemas = self::schemas($current);
        $schemaChanges = [
            'added' => array_values(array_diff(array_keys($afterSchemas), array_keys($beforeSchemas))),
            'removed' => array_values(array_diff(array_keys($beforeSchemas), array_keys($afterSchemas))),
            'changed' => [],
        ];

        foreach (array_intersect(array_keys($beforeSchemas), array_keys($afterSchemas)) as $name) {
            $before = $beforeSchemas[$name];
            $after = $afterSchemas[$name];
            $beforeFields = self::schemaFields($before);
            $afterFields = self::schemaFields($after);
            $fields = [
                'added' => array_values(array_diff(array_keys($afterFields), array_keys($beforeFields))),
                'removed' => array_values(array_diff(array_keys($beforeFields), array_keys($afterFields))),
                'changed' => [],
            ];

            foreach (array_intersect(array_keys($beforeFields), array_keys($afterFields)) as $field) {
                if (self::normalize($beforeFields[$field]) !== self::normalize($afterFields[$field])) {
                    $fields['changed'][] = $field;
                }
            }

            $beforeSchemaProperties = self::without($before, ['properties', 'required']);
            $afterSchemaProperties = self::without($after, ['properties', 'required']);
            $schemaPropertiesChanged = self::changedKeys($beforeSchemaProperties, $afterSchemaProperties);

            if ($fields['added'] !== [] || $fields['removed'] !== [] || $fields['changed'] !== [] || $schemaPropertiesChanged !== []) {
                $schemaChanges['changed'][] = [
                    'name' => $name,
                    'fields' => $fields,
                    'schemaPropertiesChanged' => $schemaPropertiesChanged,
                ];
            }
        }

        return [
            'operations' => $operationChanges,
            'schemas' => $schemaChanges,
        ];
    }

    /** @param array<string, mixed> $drift */
    public static function hasDrift(array $drift): bool
    {
        foreach ($drift['operations'] as $changes) {
            if ($changes !== []) {
                return true;
            }
        }
        foreach ($drift['schemas'] as $changes) {
            if ($changes !== []) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  array<string, mixed>  $drift
     */
    public static function markdown(array $drift, string $snapshotDate, string $detectedAt): string
    {
        $lines = [
            '# PortOne V2 OpenAPI drift report',
            '',
            '- Detected at (UTC): '.$detectedAt,
            '- Compared against snapshot retrieved at: '.$snapshotDate,
            '- Source: https://developers.portone.io/api/schema/v2/openapi.json',
            '',
        ];

        if (! self::hasDrift($drift)) {
            $lines[] = 'No operation or schema drift detected.';

            return implode("\n", $lines)."\n";
        }

        $lines[] = '## Operations';
        $lines[] = '';
        self::appendIdentities($lines, 'Added', $drift['operations']['added']);
        self::appendIdentities($lines, 'Removed', $drift['operations']['removed']);
        self::appendIdentities($lines, 'Changed', $drift['operations']['changed']);
        $lines[] = '## Schemas';
        $lines[] = '';
        self::appendNames($lines, 'Added schemas', $drift['schemas']['added']);
        self::appendNames($lines, 'Removed schemas', $drift['schemas']['removed']);
        foreach ($drift['schemas']['changed'] as $schema) {
            $lines[] = '- `'.$schema['name'].'`';
            foreach (['added' => 'added fields', 'removed' => 'removed fields', 'changed' => 'changed fields'] as $kind => $label) {
                if ($schema['fields'][$kind] !== []) {
                    $lines[] = '  - '.$label.': '.self::codeList($schema['fields'][$kind]);
                }
            }
            if ($schema['schemaPropertiesChanged'] !== []) {
                $lines[] = '  - changed schema properties: '.self::codeList($schema['schemaPropertiesChanged']);
            }
        }

        return implode("\n", $lines)."\n";
    }

    /**
     * @return array<string, array{identity: array<string, string>, definition: array<string, mixed>}>
     */
    private static function operations(array $document): array
    {
        $operations = [];
        foreach (is_array($document['paths'] ?? null) ? $document['paths'] : [] as $path => $pathItem) {
            if (! is_array($pathItem)) {
                continue;
            }
            foreach (self::HTTP_METHODS as $method) {
                $definition = $pathItem[$method] ?? null;
                if (! is_array($definition)) {
                    continue;
                }

                $identity = [
                    'method' => strtoupper($method),
                    'path' => (string) $path,
                    'operationId' => is_string($definition['operationId'] ?? null) ? $definition['operationId'] : '(no operationId)',
                ];
                $operations[$method.' '.$path] = [
                    'identity' => $identity,
                    'definition' => $definition,
                ];
            }
        }

        ksort($operations);

        return $operations;
    }

    /** @return array<string, array<string, mixed>> */
    private static function schemas(array $document): array
    {
        $schemas = $document['components']['schemas'] ?? [];
        if (! is_array($schemas)) {
            return [];
        }

        ksort($schemas);

        return $schemas;
    }

    /** @return array<string, array{schema: mixed, required: bool}> */
    private static function schemaFields(array $schema): array
    {
        $properties = is_array($schema['properties'] ?? null) ? $schema['properties'] : [];
        $required = is_array($schema['required'] ?? null) ? $schema['required'] : [];
        $fields = [];
        foreach ($properties as $name => $definition) {
            if (is_string($name)) {
                $fields[$name] = [
                    'schema' => $definition,
                    'required' => in_array($name, $required, true),
                ];
            }
        }
        ksort($fields);

        return $fields;
    }

    /** @param array<string, mixed> $before @param array<string, mixed> $after @return list<string> */
    private static function changedKeys(array $before, array $after): array
    {
        $keys = array_unique(array_merge(array_keys($before), array_keys($after)));
        $changed = [];
        foreach ($keys as $key) {
            if (! array_key_exists($key, $before)
                || ! array_key_exists($key, $after)
                || self::normalize($before[$key]) !== self::normalize($after[$key])) {
                $changed[] = (string) $key;
            }
        }
        sort($changed);

        return $changed;
    }

    private static function normalize(mixed $value): mixed
    {
        if (! is_array($value)) {
            return $value;
        }

        if (! array_is_list($value)) {
            ksort($value);
        }
        foreach ($value as $key => $item) {
            $value[$key] = self::normalize($item);
        }

        return $value;
    }

    /** @param array<string, mixed> $value @param list<string> $keys @return array<string, mixed> */
    private static function without(array $value, array $keys): array
    {
        foreach ($keys as $key) {
            unset($value[$key]);
        }

        return $value;
    }

    /** @param list<array<string, mixed>> $items */
    private static function appendIdentities(array &$lines, string $label, array $items): void
    {
        $lines[] = '### '.$label.' operations';
        if ($items === []) {
            $lines[] = '- None';
        } else {
            foreach ($items as $item) {
                $identity = '`'.$item['method'].' '.$item['path'].'` (`'.$item['operationId'].'`)';
                $lines[] = '- '.$identity.(isset($item['changes']) ? ': changed '.self::codeList($item['changes']) : '');
            }
        }
        $lines[] = '';
    }

    /** @param list<string> $names */
    private static function appendNames(array &$lines, string $label, array $names): void
    {
        $lines[] = '- '.$label.': '.($names === [] ? 'None' : self::codeList($names));
    }

    /** @param list<string> $values */
    private static function codeList(array $values): string
    {
        return implode(', ', array_map(static fn (string $value): string => '`'.$value.'`', $values));
    }
}
