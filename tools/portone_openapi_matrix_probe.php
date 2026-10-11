<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Exception\PortOneException;

require __DIR__.'/../vendor/autoload.php';

$apiSecret = getenv('PORTONE_API_SECRET');
if ($apiSecret === false || $apiSecret === '') {
    fwrite(STDERR, "PORTONE_API_SECRET is not set.\n");
    exit(1);
}

$root = dirname(__DIR__);
$document = json_decode(
    (string) file_get_contents($root.'/tests/fixtures/portone-v2-openapi.json'),
    true,
    512,
    JSON_THROW_ON_ERROR,
);
$operations = [];
foreach ($document['paths'] ?? [] as $path => $pathItem) {
    if (! is_array($pathItem)) {
        continue;
    }

    foreach ($pathItem as $method => $operation) {
        if (! in_array(strtoupper((string) $method), ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'], true)
            || ! is_array($operation)
            || ! is_string($operation['operationId'] ?? null)) {
            continue;
        }

        $operations[$operation['operationId']] = [
            'method' => strtoupper((string) $method),
            'path' => (string) $path,
        ];
    }
}

$clients = [];
foreach (glob($root.'/src/*Client.php') ?: [] as $clientPath) {
    $class = 'Cable8mm\\PortonePhp\\'.basename($clientPath, '.php');
    if ($class === 'Cable8mm\\PortonePhp\\AbstractClient' || ! class_exists($class)) {
        continue;
    }

    $clients[$class] = new $class($apiSecret);
}

$observations = [];
$missing = [];
foreach ($operations as $operationId => $definition) {
    $client = null;
    foreach ($clients as $candidate) {
        if (method_exists($candidate, $operationId)) {
            $client = $candidate;
            break;
        }
    }

    if ($client === null) {
        $missing[] = $operationId;

        continue;
    }

    $startedAt = microtime(true);
    try {
        $result = $client->{$operationId}();
        $observations[$operationId] = [
            'client' => $client::class,
            'method' => $definition['method'],
            'path' => $definition['path'],
            'status' => 'success',
            'resultType' => is_object($result) ? $result::class : get_debug_type($result),
            'elapsedMilliseconds' => round((microtime(true) - $startedAt) * 1000, 1),
        ];
    } catch (PortOneException $exception) {
        $observations[$operationId] = [
            'client' => $client::class,
            'method' => $definition['method'],
            'path' => $definition['path'],
            'status' => 'controlled-failure',
            'exception' => $exception::class,
            'statusCode' => $exception->status,
            'errorType' => $exception->errorType,
            'elapsedMilliseconds' => round((microtime(true) - $startedAt) * 1000, 1),
        ];
    } catch (Throwable $exception) {
        $observations[$operationId] = [
            'client' => $client::class,
            'method' => $definition['method'],
            'path' => $definition['path'],
            'status' => 'local-failure',
            'exception' => $exception::class,
            'message' => $exception->getMessage(),
            'elapsedMilliseconds' => round((microtime(true) - $startedAt) * 1000, 1),
        ];
    }
}

$report = [
    'status' => $missing === [] && ! in_array('local-failure', array_column($observations, 'status'), true)
        ? 'observed'
        : 'failed',
    'boundary' => 'https://api.portone.io',
    'operationCount' => count($operations),
    'observedCount' => count($observations),
    'controlledFailureCount' => count(array_filter($observations, static fn (array $observation): bool => $observation['status'] === 'controlled-failure')),
    'successCount' => count(array_filter($observations, static fn (array $observation): bool => $observation['status'] === 'success')),
    'missingOperations' => $missing,
    'operations' => $observations,
];

$recordPath = $root.'/tests/fixtures/portone-v2-openapi-matrix-observations.json';
$json = json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR).PHP_EOL;
if (file_put_contents($recordPath, $json) === false) {
    fwrite(STDERR, "Could not write OpenAPI matrix observations.\n");
    exit(1);
}

echo $json;
if ($report['status'] !== 'observed') {
    exit(1);
}
