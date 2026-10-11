<?php

declare(strict_types=1);

/**
 * Compares the OpenAPI operation inventory with the PHP public client methods.
 */
$arguments = array_slice($argv, 1);
$fixture = dirname(__DIR__).'/tests/fixtures/portone-v2-openapi.json';
$metadata = json_decode((string) file_get_contents(dirname(__DIR__).'/tests/fixtures/portone-v2-openapi.meta.json'), true, 512, JSON_THROW_ON_ERROR);
$document = json_decode((string) file_get_contents($fixture), true, 512, JSON_THROW_ON_ERROR);

$httpMethods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];
$operations = [];
foreach ($document['paths'] ?? [] as $path => $pathItem) {
    foreach ($pathItem as $method => $operation) {
        if (! in_array(strtoupper((string) $method), $httpMethods, true) || ! is_array($operation)) {
            continue;
        }

        $operations[] = [
            'operationId' => $operation['operationId'] ?? null,
            'method' => strtoupper((string) $method),
            'path' => $path,
        ];
    }
}

$phpMethods = [];
foreach (glob(dirname(__DIR__).'/src/*Client.php') ?: [] as $path) {
    $source = (string) file_get_contents($path);
    preg_match_all('/public function ([A-Za-z_]\w*)\s*\(/', $source, $matches);
    foreach ($matches[1] ?? [] as $method) {
        if ($method !== '__construct') {
            $phpMethods[$method] = basename($path, '.php');
        }
    }
}

$operationIds = array_values(array_filter(array_map(
    static fn (array $operation): ?string => is_string($operation['operationId']) ? $operation['operationId'] : null,
    $operations,
)));
$expectedMethods = [];
foreach ($operationIds as $operationId) {
    $expectedMethods[] = $operationId;
    $expectedMethods[] = $operationId.'Async';
}

$report = [
    'source' => 'https://developers.portone.io/api/schema/v2/openapi.json',
    'retrievedAt' => $metadata['retrievedAt'] ?? null,
    'fixture' => $fixture,
    'openapi' => $document['openapi'] ?? null,
    'paths' => count($document['paths'] ?? []),
    'operations' => count($operations),
    'operationIdsWithoutMethod' => array_values(array_diff($expectedMethods, array_keys($phpMethods))),
    'unexpectedPublicMethods' => array_values(array_diff(array_keys($phpMethods), $expectedMethods)),
    'methods' => $phpMethods,
];

echo json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL;

if (in_array('--check-php', $arguments, true)
    && ($report['operationIdsWithoutMethod'] !== [] || $report['unexpectedPublicMethods'] !== [])) {
    exit(1);
}
