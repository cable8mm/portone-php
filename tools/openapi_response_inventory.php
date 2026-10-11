<?php

declare(strict_types=1);

/**
 * Inventories OpenAPI success response schemas against PHP response classes.
 */

/** @return array<string, mixed> */
function resolveReference(array $document, mixed $value): array
{
    if (! is_array($value) || ! isset($value['$ref']) || ! is_string($value['$ref'])) {
        return is_array($value) ? $value : [];
    }

    $reference = $value['$ref'];
    if (! str_starts_with($reference, '#/')) {
        return [];
    }

    $resolved = $document;
    foreach (explode('/', substr($reference, 2)) as $part) {
        $part = str_replace(['~1', '~0'], ['/', '~'], $part);
        if (! is_array($resolved) || ! array_key_exists($part, $resolved)) {
            return [];
        }
        $resolved = $resolved[$part];
    }

    return is_array($resolved) ? $resolved : [];
}

/** @return array{schemaNames: array<int, string>, union: array<int, string>, fields: array<string, array<string, mixed>>, nullable: bool} */
function describeSchema(array $document, mixed $schema): array
{
    $schemaNames = [];
    $union = [];
    $nullable = false;
    $fields = [];

    if (is_array($schema) && isset($schema['$ref']) && is_string($schema['$ref'])) {
        $parts = explode('/', $schema['$ref']);
        $schemaNames[] = (string) end($parts);
        $schema = resolveReference($document, $schema);
    }

    if (! is_array($schema)) {
        return compact('schemaNames', 'union', 'fields', 'nullable');
    }

    $nullable = ($schema['nullable'] ?? false) === true;
    foreach (['oneOf', 'anyOf'] as $unionKey) {
        if (! is_array($schema[$unionKey] ?? null)) {
            continue;
        }
        foreach ($schema[$unionKey] as $variant) {
            $variantDescription = describeSchema($document, $variant);
            $schemaNames = array_merge($schemaNames, $variantDescription['schemaNames']);
            $union = array_merge($union, $variantDescription['schemaNames']);
            $nullable = $nullable || $variantDescription['nullable'];
        }
    }

    if (is_array($schema['allOf'] ?? null)) {
        foreach ($schema['allOf'] as $part) {
            $partDescription = describeSchema($document, $part);
            $schemaNames = array_merge($schemaNames, $partDescription['schemaNames']);
            $fields = array_merge($fields, $partDescription['fields']);
            $nullable = $nullable || $partDescription['nullable'];
        }
    }

    foreach (is_array($schema['properties'] ?? null) ? $schema['properties'] : [] as $name => $property) {
        $propertyDescription = describeSchema($document, $property);
        $fields[(string) $name] = [
            'schemaNames' => $propertyDescription['schemaNames'],
            'type' => $property['type'] ?? null,
            'nullable' => $propertyDescription['nullable'],
            'required' => in_array($name, $schema['required'] ?? [], true),
            'union' => $propertyDescription['union'],
        ];
    }

    return [
        'schemaNames' => array_values(array_unique($schemaNames)),
        'union' => array_values(array_unique($union)),
        'fields' => $fields,
        'nullable' => $nullable,
    ];
}

/** @return array<string, array<string, mixed>> */
function parsePhpResponses(string $directory): array
{
    $responses = [];
    foreach (glob($directory.'/*.php') ?: [] as $path) {
        $source = (string) file_get_contents($path);
        if (! preg_match('/final\s+class\s+([A-Za-z_]\w*)\s+extends\s+OperationResponse|final\s+class\s+([A-Za-z_]\w*)/', $source, $class)) {
            continue;
        }

        $name = $class[1] !== '' ? $class[1] : $class[2];
        preg_match_all('/public\s+readonly\s+(?<type>[^$\s]+)\s+\$(?<name>[A-Za-z_]\w*)/', $source, $properties, PREG_SET_ORDER);
        $fields = [];
        foreach ($properties as $property) {
            if ($property['name'] === 'data') {
                continue;
            }
            $fields[$property['name']] = [
                'type' => $property['type'],
                'nullable' => str_starts_with($property['type'], '?'),
            ];
        }

        $responses[$name] = [
            'path' => $path,
            'fields' => $fields,
            'rawData' => str_contains($source, 'extends OperationResponse') && $fields === [],
            'union' => preg_match('/\b(?:oneOf|anyOf|Unknown|Unrecognized)\b/i', $source) === 1,
        ];
    }

    return $responses;
}

/** @return array<string, array<string, mixed>> */
function parsePhpOperationReturns(string $directory): array
{
    $returns = [];
    foreach (glob($directory.'/*Client.php') ?: [] as $path) {
        $source = (string) file_get_contents($path);
        preg_match_all(
            '/public\s+function\s+(?<name>[A-Za-z_]\w*)\s*\([^)]*\)\s*:\s*(?<return>[^{\s]+)/s',
            $source,
            $methods,
            PREG_SET_ORDER,
        );
        foreach ($methods as $method) {
            if ($method['name'] === '__construct' || str_ends_with($method['name'], 'Async')) {
                continue;
            }
            $return = ltrim($method['return'], '\\');
            $return = str_starts_with($return, 'Response\\') ? substr($return, 9) : $return;
            $returns[$method['name']] = [
                'client' => basename($path, '.php'),
                'returnType' => $return,
                'rawReturn' => in_array($return, ['string', 'array', 'mixed', 'void'], true),
            ];
        }
    }

    return $returns;
}

/** @return array{method: string, path: string, operationId: string, response: array<string, mixed>} */
function operationResponse(array $document, string $path, string $method, array $operation): array
{
    $successResponses = [];
    foreach ($operation['responses'] ?? [] as $status => $response) {
        if (preg_match('/^2\d\d$/', (string) $status) !== 1 || ! is_array($response)) {
            continue;
        }
        $schema = $response['content']['application/json']['schema'] ?? null;
        $successResponses[(string) $status] = describeSchema($document, $schema);
    }

    return [
        'method' => strtoupper($method),
        'path' => $path,
        'operationId' => (string) ($operation['operationId'] ?? ''),
        'response' => [
            'statuses' => array_keys($successResponses),
            'schemas' => $successResponses,
        ],
    ];
}

$root = dirname(__DIR__);
$document = json_decode((string) file_get_contents($root.'/tests/fixtures/portone-v2-openapi.json'), true, 512, JSON_THROW_ON_ERROR);
$phpResponses = parsePhpResponses($root.'/src/Response');
$phpReturns = parsePhpOperationReturns($root.'/src');
$operations = [];
$mismatches = [];

foreach ($document['paths'] ?? [] as $path => $pathItem) {
    foreach ($pathItem as $method => $operation) {
        if (! in_array(strtoupper((string) $method), ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'], true) || ! is_array($operation)) {
            continue;
        }

        $description = operationResponse($document, (string) $path, (string) $method, $operation);
        $operationId = $description['operationId'];
        $actual = $phpReturns[$operationId] ?? null;
        $schemaNames = [];
        $expectedFields = [];
        $expectedNullable = [];
        $unions = [];
        foreach ($description['response']['schemas'] as $schema) {
            foreach ($schema['schemaNames'] as $schemaName) {
                $schemaNames[] = $schemaName;
            }
            foreach ($schema['fields'] as $field => $fieldDescription) {
                $expectedFields[$field] = $fieldDescription;
                $expectedNullable[$field] = $fieldDescription['nullable'];
            }
            $unions = array_merge($unions, $schema['union']);
        }
        $schemaNames = array_values(array_unique($schemaNames));
        $unions = array_values(array_unique($unions));
        $actualClass = is_array($actual) ? ($phpResponses[$actual['returnType']] ?? null) : null;
        $actualFields = is_array($actualClass) ? $actualClass['fields'] : [];
        $missingFields = array_values(array_diff(array_keys($expectedFields), array_keys($actualFields)));
        $unexpectedFields = array_values(array_diff(array_keys($actualFields), array_keys($expectedFields)));
        $typeMismatches = [];
        $nullableMismatches = [];
        foreach (array_intersect(array_keys($expectedFields), array_keys($actualFields)) as $field) {
            $expectedIsNullable = $expectedNullable[$field];
            $actualIsNullable = $actualFields[$field]['nullable'];
            $fieldIsRequired = $expectedFields[$field]['required'];
            // PHP uses null to represent an absent optional OpenAPI property.
            // That is compatible with a non-nullable, non-required schema field;
            // an explicitly present null is rejected by the response decoder.
            if (($expectedIsNullable && ! $actualIsNullable) || (! $expectedIsNullable && $actualIsNullable && $fieldIsRequired)) {
                $nullableMismatches[] = $field;
            }
            $expectedType = $expectedFields[$field]['type'];
            $actualType = ltrim($actualFields[$field]['type'], '?');
            $compatible = match ($expectedType) {
                'integer' => in_array($actualType, ['int', 'integer'], true),
                'number' => in_array($actualType, ['int', 'integer', 'float'], true),
                'boolean' => in_array($actualType, ['bool', 'boolean'], true),
                'string' => $actualType === 'string',
                'array' => $actualType === 'array',
                'object' => $actualType === 'array',
                default => true,
            };
            if (! $compatible) {
                $typeMismatches[$field] = ['expected' => $expectedType, 'actual' => $actualFields[$field]['type']];
            }
        }
        $status = 'match';
        $hasStructuredSchema = $schemaNames !== [] || $expectedFields !== [] || $unions !== [];
        if ($actual === null || ($hasStructuredSchema && $actualClass === null) || $missingFields !== [] || $unexpectedFields !== [] || $nullableMismatches !== [] || $typeMismatches !== [] || ($hasStructuredSchema && ($actualClass['rawData'] ?? false))) {
            $status = 'mismatch';
        }
        $operations[$operationId] = [
            'status' => $status,
            'method' => $description['method'],
            'path' => $description['path'],
            'successResponseSchemas' => $schemaNames,
            'successStatuses' => $description['response']['statuses'],
            'unions' => $unions,
            'php' => $actual === null ? null : [
                'client' => $actual['client'],
                'returnType' => $actual['returnType'],
                'rawReturn' => $actual['rawReturn'],
                'rawDataWrapper' => $actualClass['rawData'] ?? false,
            ],
            'missingResponseClass' => $actualClass === null,
            'missingFields' => $missingFields,
            'unexpectedFields' => $unexpectedFields,
            'typeMismatches' => $typeMismatches,
            'nullableMismatches' => $nullableMismatches,
            'expectedFields' => $expectedFields,
            'actualFields' => $actualFields,
        ];
        if ($status === 'mismatch') {
            $mismatches[$operationId] = true;
        }
    }
}

$report = [
    'source' => 'https://developers.portone.io/api/schema/v2/openapi.json',
    'fixture' => $root.'/tests/fixtures/portone-v2-openapi.json',
    'openapi' => $document['openapi'] ?? null,
    'summary' => [
        'operations' => count($operations),
        'matched' => count($operations) - count($mismatches),
        'mismatched' => count($mismatches),
        'phpResponseClasses' => count($phpResponses),
    ],
    'operations' => $operations,
];

echo json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL;

if (in_array('--check', $argv, true) && $mismatches !== []) {
    exit(1);
}
