<?php

declare(strict_types=1);

/**
 * Compares the OpenAPI operation inventory and input signatures with PHP clients.
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

/** @return array<string, mixed> */
function resolveSchema(array $document, mixed $schema): array
{
    $schema = resolveReference($document, $schema);
    if (isset($schema['$ref'])) {
        return resolveSchema($document, $schema);
    }

    return $schema;
}

/** @return array{all: array<int, string>, required: array<int, string>} */
function schemaFields(array $document, mixed $schema): array
{
    $schema = resolveSchema($document, $schema);
    $properties = is_array($schema['properties'] ?? null) ? $schema['properties'] : [];

    return [
        'all' => array_values(array_keys($properties)),
        'required' => array_values(array_filter(
            is_array($schema['required'] ?? null) ? $schema['required'] : [],
            'is_string',
        )),
    ];
}

/** @return array{parameters: array<string, array<int, string>>, body: array<string, array<int, string>>} */
function openApiInputs(array $document, array $pathItem, array $operation): array
{
    $parameters = [];
    foreach (array_merge(
        is_array($pathItem['parameters'] ?? null) ? $pathItem['parameters'] : [],
        is_array($operation['parameters'] ?? null) ? $operation['parameters'] : [],
    ) as $parameter) {
        $parameter = resolveReference($document, $parameter);
        $name = $parameter['name'] ?? null;
        $location = $parameter['in'] ?? null;
        if (! is_string($name) || ! is_string($location)) {
            continue;
        }

        if (isset($parameter['content']['application/json']['schema'])) {
            $fields = schemaFields($document, $parameter['content']['application/json']['schema']);
            $parameters[$location] = array_values(array_unique(array_merge(
                $parameters[$location] ?? [],
                $fields['all'],
            )));
            $parameters[$location.'Required'] = array_values(array_unique(array_merge(
                $parameters[$location.'Required'] ?? [],
                $fields['required'],
            )));

            continue;
        }

        $parameters[$location][] = $name;
        if (($parameter['required'] ?? false) === true) {
            $parameters[$location.'Required'][] = $name;
        }
    }

    $body = ['all' => [], 'required' => []];
    if (isset($operation['requestBody']['content']['application/json']['schema'])) {
        $body = schemaFields($document, $operation['requestBody']['content']['application/json']['schema']);
    }

    return [
        'parameters' => [
            'path' => array_values(array_unique($parameters['path'] ?? [])),
            'query' => array_values(array_unique($parameters['query'] ?? [])),
            'pathRequired' => array_values(array_unique($parameters['pathRequired'] ?? [])),
            'queryRequired' => array_values(array_unique($parameters['queryRequired'] ?? [])),
        ],
        'body' => $body,
    ];
}

/** @return array{all: array<int, string>, required: array<int, string>} */
function parsePhpParameters(string $signature): array
{
    preg_match_all('/\$(?<name>[A-Za-z_]\w*)\s*(?<default>=\s*[^,]+)?/', $signature, $matches, PREG_SET_ORDER);

    $all = [];
    $required = [];
    foreach ($matches as $match) {
        $name = $match['name'];
        $all[] = $name;
        if (($match['default'] ?? '') === '') {
            $required[] = $name;
        }
    }

    return ['all' => $all, 'required' => $required];
}

/** @return array<string, array<string, mixed>> */
function parsePhpMethods(string $directory): array
{
    $methods = [];
    foreach (glob($directory.'/*Client.php') ?: [] as $path) {
        $source = (string) file_get_contents($path);
        preg_match_all(
            '/public\s+function\s+(?<name>[A-Za-z_]\w*)\s*\((?<signature>.*?)\)(?:\s*:[^{]+)?\s*\{/s',
            $source,
            $matches,
            PREG_SET_ORDER | PREG_OFFSET_CAPTURE,
        );

        foreach ($matches as $index => $match) {
            $name = $match['name'][0];
            if ($name === '__construct') {
                continue;
            }

            $bodyStart = $match[0][1] + strlen($match[0][0]);
            $nextStart = $matches[$index + 1]['name'][1] ?? strlen($source);
            $body = substr($source, $bodyStart, $nextStart - $bodyStart);
            $baseName = str_ends_with($name, 'Async') ? substr($name, 0, -5) : $name;
            $route = null;

            if (preg_match(
                "/(?<helper>call(?:Operation|StringOperation|UnitOperation)(?:WithQueryAndBody|WithQueryRequestBody|WithQuery)?(?:Async)?)\\s*\\(\\s*'(?<operationId>[^']+)'\\s*,\\s*'(?<method>[A-Z]+)'\\s*,\\s*'(?<path>[^']+)'(?<arguments>.*?)\\);/s",
                $body,
                $routeMatch,
            )) {
                $route = [
                    'operationId' => $routeMatch['operationId'],
                    'method' => $routeMatch['method'],
                    'path' => $routeMatch['path'],
                    'arguments' => $routeMatch['arguments'],
                    'source' => $routeMatch['helper'],
                ];
            } elseif (preg_match(
                "/->request(?:Async)?\\s*\\(\\s*'(?<method>[A-Z]+)'\\s*,\\s*'(?<path>[^']+)'/s",
                $body,
                $routeMatch,
            )) {
                $route = [
                    'operationId' => $baseName,
                    'method' => $routeMatch['method'],
                    'path' => $routeMatch['path'],
                    'arguments' => '',
                    'source' => 'request',
                ];
            }

            $methods[$name] = [
                'client' => basename($path, '.php'),
                'parameters' => parsePhpParameters($match['signature'][0]),
                'route' => $route,
            ];
        }
    }

    return $methods;
}

/** @return array<int, string> */
function arrayKeysFromLiteral(string $value): array
{
    preg_match_all("/'([A-Za-z_]\\w*)'\\s*=>/", $value, $matches);

    return array_values(array_unique($matches[1] ?? []));
}

/** @return array{query: array<int, string>, body: array<int, string>} */
function parsePhpRouting(array $method): array
{
    $route = $method['route'] ?? null;
    if (! is_array($route)) {
        return ['query' => [], 'body' => []];
    }

    if (($route['source'] ?? null) === 'request') {
        return ['query' => $method['parameters']['all'] ?? [], 'body' => []];
    }

    $arguments = (string) ($route['arguments'] ?? '');
    preg_match_all('/\[(?<literal>[^\]]*)\]/s', $arguments, $matches);
    $literals = $matches['literal'] ?? [];

    if (str_contains((string) $route['source'], 'WithQueryAndBody')) {
        return [
            'query' => arrayKeysFromLiteral($literals[0] ?? ''),
            'body' => arrayKeysFromLiteral($literals[1] ?? ''),
        ];
    }

    if (str_contains((string) $route['source'], 'WithQueryRequestBody')) {
        return [
            'query' => array_values(array_unique(array_merge(
                arrayKeysFromLiteral($literals[0] ?? ''),
                arrayKeysFromLiteral($literals[1] ?? ''),
            ))),
            'body' => [],
        ];
    }

    if (str_ends_with((string) $route['source'], 'WithQuery')
        || str_ends_with((string) $route['source'], 'WithQueryAsync')) {
        return [
            'query' => arrayKeysFromLiteral($literals[0] ?? ''),
            'body' => [],
        ];
    }

    $parameters = arrayKeysFromLiteral($literals[0] ?? '');
    $requestBody = str_ends_with((string) $route['arguments'], ', true');
    if ($requestBody && ($route['method'] ?? null) !== 'GET') {
        return ['query' => [], 'body' => $parameters];
    }

    return [
        'query' => $parameters,
        'body' => [],
    ];
}

$arguments = array_slice($argv, 1);
$root = dirname(__DIR__);
$fixture = $root.'/tests/fixtures/portone-v2-openapi.json';
$metadata = json_decode((string) file_get_contents($root.'/tests/fixtures/portone-v2-openapi.meta.json'), true, 512, JSON_THROW_ON_ERROR);
$document = json_decode((string) file_get_contents($fixture), true, 512, JSON_THROW_ON_ERROR);
$phpMethods = parsePhpMethods($root.'/src');

$httpMethods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];
$operations = [];
foreach ($document['paths'] ?? [] as $path => $pathItem) {
    foreach ($pathItem as $method => $operation) {
        if (! in_array(strtoupper((string) $method), $httpMethods, true) || ! is_array($operation)) {
            continue;
        }

        $operationId = $operation['operationId'] ?? null;
        if (! is_string($operationId)) {
            continue;
        }

        $inputs = openApiInputs($document, is_array($pathItem) ? $pathItem : [], $operation);
        $operations[$operationId] = [
            'operationId' => $operationId,
            'method' => strtoupper((string) $method),
            'path' => $path,
            'inputs' => $inputs,
        ];
    }
}

$operationIds = array_keys($operations);
$expectedMethods = [];
foreach ($operationIds as $operationId) {
    $expectedMethods[] = $operationId;
    $expectedMethods[] = $operationId.'Async';
}

$signatureComparison = [];
foreach ($operations as $operationId => $operation) {
    $expectedParameters = array_values(array_unique(array_merge(
        $operation['inputs']['parameters']['path'],
        $operation['inputs']['parameters']['query'],
        $operation['inputs']['body']['all'],
    )));
    $expectedRequired = array_values(array_unique(array_merge(
        $operation['inputs']['parameters']['pathRequired'],
        $operation['inputs']['parameters']['queryRequired'],
        $operation['inputs']['body']['required'],
    )));

    foreach ([$operationId, $operationId.'Async'] as $methodName) {
        $method = $phpMethods[$methodName] ?? null;
        $actualParameters = is_array($method) ? $method['parameters']['all'] : [];
        $actualRequired = is_array($method) ? $method['parameters']['required'] : [];
        $actualRouting = is_array($method) ? parsePhpRouting($method) : ['query' => [], 'body' => []];
        $actualRouting['query'] = array_values(array_diff(
            $actualRouting['query'],
            $operation['inputs']['parameters']['path'],
        ));
        $actualRouting['body'] = array_values(array_diff(
            $actualRouting['body'],
            $operation['inputs']['parameters']['path'],
        ));
        $routeMismatches = ! is_array($method) || ! is_array($method['route'] ?? null)
            ? ['routeNotFound']
            : array_values(array_filter([
                $method['route']['method'] !== $operation['method'] ? 'httpMethod' : null,
                $method['route']['path'] !== $operation['path'] ? 'path' : null,
                $method['route']['operationId'] !== $operationId ? 'operationId' : null,
            ]));

        $signatureComparison[$methodName] = [
            'operationId' => $operationId,
            'client' => is_array($method) ? $method['client'] : null,
            'route' => is_array($method) ? $method['route'] : null,
            'expected' => [
                'method' => $operation['method'],
                'path' => $operation['path'],
                'pathParameters' => $operation['inputs']['parameters']['path'],
                'queryParameters' => $operation['inputs']['parameters']['query'],
                'requestBodyFields' => $operation['inputs']['body']['all'],
                'requiredParameters' => $expectedRequired,
            ],
            'actual' => [
                'parameters' => $actualParameters,
                'requiredParameters' => $actualRequired,
                'queryParameters' => $actualRouting['query'],
                'requestBodyFields' => $actualRouting['body'],
            ],
            'mismatches' => [
                'route' => $routeMismatches,
                'missingParameters' => array_values(array_diff($expectedParameters, $actualParameters)),
                'unexpectedParameters' => array_values(array_diff($actualParameters, $expectedParameters)),
                'requiredness' => [
                    'requiredInOpenApiButOptionalInPhp' => array_values(array_diff($expectedRequired, $actualRequired)),
                    'optionalInOpenApiButRequiredInPhp' => array_values(array_diff($actualRequired, $expectedRequired)),
                ],
                'queryParameters' => array_values(array_diff($operation['inputs']['parameters']['query'], $actualRouting['query'])),
                'requestBodyFields' => array_values(array_diff($operation['inputs']['body']['all'], $actualRouting['body'])),
            ],
        ];
    }
}

$signatureFailures = array_filter(
    $signatureComparison,
    static fn (array $comparison): bool => $comparison['mismatches']['route'] !== []
        || $comparison['mismatches']['missingParameters'] !== []
        || $comparison['mismatches']['unexpectedParameters'] !== []
        || $comparison['mismatches']['queryParameters'] !== []
        || $comparison['mismatches']['requestBodyFields'] !== [],
);

$requirednessDifferences = array_filter(
    $signatureComparison,
    static fn (array $comparison): bool => $comparison['mismatches']['requiredness']['requiredInOpenApiButOptionalInPhp'] !== []
        || $comparison['mismatches']['requiredness']['optionalInOpenApiButRequiredInPhp'] !== [],
);

$report = [
    'source' => 'https://developers.portone.io/api/schema/v2/openapi.json',
    'retrievedAt' => $metadata['retrievedAt'] ?? null,
    'fixture' => $fixture,
    'openapi' => $document['openapi'] ?? null,
    'paths' => count($document['paths'] ?? []),
    'operations' => count($operations),
    'operationIdsWithoutMethod' => array_values(array_diff($expectedMethods, array_keys($phpMethods))),
    'unexpectedPublicMethods' => array_values(array_diff(array_keys($phpMethods), $expectedMethods)),
    'signatureFailures' => array_keys($signatureFailures),
    'signatureFailureCount' => count($signatureFailures),
    'requirednessDifferences' => array_keys($requirednessDifferences),
    'requirednessDifferenceCount' => count($requirednessDifferences),
    'methods' => $phpMethods,
    'signatures' => $signatureComparison,
];

echo json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL;

if (in_array('--check-php', $arguments, true)
    && ($report['operationIdsWithoutMethod'] !== [] || $report['unexpectedPublicMethods'] !== [])) {
    exit(1);
}

if (in_array('--check-signatures', $arguments, true)
    && ($report['operationIdsWithoutMethod'] !== []
        || $report['unexpectedPublicMethods'] !== []
        || $report['signatureFailureCount'] !== 0)) {
    exit(1);
}
