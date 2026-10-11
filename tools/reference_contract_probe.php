<?php

declare(strict_types=1);

/**
 * Records the public contract observed in the JVM SDK reference tag.
 *
 * Usage:
 *   php tools/reference_contract_probe.php
 *   php tools/reference_contract_probe.php --verify-record
 *   php tools/reference_contract_probe.php --verify-public-contract=path/to/contract.json
 */
const REFERENCE_TAG = 'jvm-v0.24.0';
const DEFAULT_JVM_PATH = '/Users/cable8mm/Herd/server-sdk/jvm';
const RECORD_PATH = __DIR__.'/../tests/fixtures/jvm-v0.24.0-contract.json';

$jvmPath = DEFAULT_JVM_PATH;
$mode = 'record';
$publicContractPath = null;

foreach (array_slice($argv, 1) as $argument) {
    if (str_starts_with($argument, '--jvm=')) {
        $jvmPath = substr($argument, 6);

        continue;
    }

    if ($argument === '--verify-record') {
        $mode = 'verify-record';

        continue;
    }

    if (str_starts_with($argument, '--verify-public-contract=')) {
        $mode = 'verify-public-contract';
        $publicContractPath = substr($argument, strlen('--verify-public-contract='));

        continue;
    }

    fail('Unknown argument: '.$argument);
}

$observed = observeReference($jvmPath);

if ($mode === 'record') {
    $directory = dirname(RECORD_PATH);
    if (! is_dir($directory) && ! mkdir($directory, 0777, true) && ! is_dir($directory)) {
        fail('Could not create record directory: '.$directory);
    }

    $json = json_encode($observed, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL;
    if (file_put_contents(RECORD_PATH, $json) === false) {
        fail('Could not write record: '.RECORD_PATH);
    }

    echo 'Recorded '.count($observed['clients']).' clients, '
        .count($observed['webhookTypes']).' webhook types, '
        .operationCount($observed).' operations, and '
        .asyncOperationCount($observed)." async methods.\n";
    exit(0);
}

if (! is_file(RECORD_PATH)) {
    fail('Record does not exist: '.RECORD_PATH);
}

$recorded = json_decode((string) file_get_contents(RECORD_PATH), true, 512, JSON_THROW_ON_ERROR);

if ($mode === 'verify-record') {
    if ($recorded !== $observed) {
        fail('The JVM observation differs from the recorded contract.');
    }

    echo "Recorded JVM contract is reproducible.\n";
    exit(0);
}

if ($publicContractPath === null || ! is_file($publicContractPath)) {
    fail('PHP public contract does not exist: '.($publicContractPath ?? '(missing path)'));
}

$publicContract = json_decode((string) file_get_contents($publicContractPath), true, 512, JSON_THROW_ON_ERROR);
$expected = [
    'clients' => $recorded['clients'],
    'webhookTypes' => $recorded['webhookTypes'],
];

if (($publicContract['clients'] ?? null) !== $expected['clients']
    || ($publicContract['webhookTypes'] ?? null) !== $expected['webhookTypes']) {
    fail('The PHP public contract differs from the recorded JVM contract.');
}

echo "PHP public contract matches the recorded JVM contract.\n";

/** @return array<string,mixed> */
function observeReference(string $jvmPath): array
{
    $commit = trim(runGit($jvmPath, ['rev-parse', REFERENCE_TAG]));
    $paths = lines(runGit($jvmPath, [
        'ls-tree', '-r', '--name-only', REFERENCE_TAG, '--',
        'lib/src/generated/kotlin/io/portone/sdk/server',
    ]));

    $clients = [];
    $webhookTypes = [];
    $webhookVerifier = '';
    $unknownApiErrorObserved = false;
    $unknownSuccessObserved = false;

    foreach ($paths as $path) {
        if (preg_match('#^lib/src/generated/kotlin/io/portone/sdk/server/(.+/)?([^/]+Client)\.kt$#', $path, $matches)) {
            if ($matches[2] === 'PortOneClient') {
                continue;
            }

            $source = showFile($jvmPath, $path);
            $unknownApiErrorObserved = $unknownApiErrorObserved
                || str_contains($source, 'throw UnknownException("Unknown API error: $httpBody")');
            $unknownSuccessObserved = $unknownSuccessObserved
                || str_contains($source, 'throw UnknownException("Unknown API response: $httpBody")');
            $operations = [];
            $asyncOperations = [];
            preg_match_all('/public\s+suspend\s+fun\s+([A-Za-z_]\w*)\s*\(/', $source, $methods, PREG_OFFSET_CAPTURE);
            preg_match_all('/public\s+fun\s+([A-Za-z_]\w*Future)\s*\(/', $source, $futureMethods);

            foreach ($futureMethods[1] ?? [] as $futureMethod) {
                $asyncOperations[substr($futureMethod, 0, -strlen('Future'))] = $futureMethod;
            }
            ksort($asyncOperations);

            foreach ($methods[1] as [$name, $offset]) {
                $signatureStart = strrpos(substr($source, 0, $offset), 'public');
                if ($signatureStart === false) {
                    fail('Could not locate signature for '.$name.' in '.$path);
                }

                $openParenthesis = strpos($source, '(', $offset + strlen($name));
                if ($openParenthesis === false) {
                    fail('Could not locate parameters for '.$name.' in '.$path);
                }

                [$parameters, $afterParameters] = balancedParentheses($source, $openParenthesis);
                $returnType = parseReturnType($source, $afterParameters);
                $body = functionBody($source, $afterParameters);
                preg_match_all('/throw\s+([A-Za-z_]\w*Exception)\s*\(/', $body, $throws);

                $operations[$name] = [
                    'parameters' => parseParameters($parameters),
                    'returnType' => $returnType,
                    'errors' => array_values(array_unique($throws[1] ?? [])),
                ];
            }

            ksort($operations);
            $clientName = $matches[2];
            $clients[$clientName] = [
                'path' => $path,
                'operations' => $operations,
                'asyncOperations' => $asyncOperations,
            ];
        }

        if (str_contains($path, '/webhook/') && str_ends_with($path, '.kt')) {
            $source = showFile($jvmPath, $path);
            preg_match_all(
                '/public\s+(?:(?:sealed|data)\s+)*(?:interface|class|object|enum\s+class)\s+([A-Za-z_]\w*)/',
                $source,
                $declarations,
            );
            foreach ($declarations[1] ?? [] as $declaration) {
                $webhookTypes[] = $declaration;
            }
        }
    }

    $verifierPath = 'lib/src/main/kotlin/io/portone/sdk/server/webhook/WebhookVerifier.kt';
    $webhookVerifier = showFile($jvmPath, $verifierPath);
    ksort($clients);
    $webhookTypes = array_values(array_unique($webhookTypes));
    sort($webhookTypes);

    return [
        'reference' => [
            'tag' => REFERENCE_TAG,
            'commit' => $commit,
        ],
        'clients' => $clients,
        'webhookTypes' => $webhookTypes,
        'behavior' => [
            'operationMethods' => 'public suspend fun is the synchronous operation; public *Future methods are the asynchronous counterpart',
            'unknownApiError' => $unknownApiErrorObserved,
            'unknownSuccess' => $unknownSuccessObserved,
            'webhookJsonIgnoresUnknownKeys' => str_contains($webhookVerifier, 'Json { ignoreUnknownKeys = true }'),
            'webhookSignature' => 'HMAC-SHA256 over msgId.timestamp.rawBody with v1 Base64 signatures',
            'webhookTimestampToleranceSeconds' => 300,
            'webhookBody' => 'raw String is included in the signature before JSON decoding',
        ],
    ];
}

/** @return list<string> */
function parseParameters(string $parameters): array
{
    $names = [];
    foreach (preg_split('/\R/', $parameters) ?: [] as $line) {
        $line = preg_replace('/\/\/.*$/', '', $line) ?? $line;
        if (preg_match('/^\s*(?:`([^`]+)`|([A-Za-z_]\w*))\s*(?::|=)/', $line, $match)) {
            $names[] = $match[1] !== '' ? $match[1] : $match[2];
        }
    }

    return $names;
}

/** @return array{0:string,1:int} */
function balancedParentheses(string $source, int $open): array
{
    $depth = 0;
    $length = strlen($source);
    for ($index = $open; $index < $length; $index++) {
        $character = $source[$index];
        if ($character === '(') {
            $depth++;
        } elseif ($character === ')') {
            $depth--;
            if ($depth === 0) {
                return [substr($source, $open + 1, $index - $open - 1), $index + 1];
            }
        }
    }

    fail('Unbalanced function parameters.');
}

function parseReturnType(string $source, int $afterParameters): string
{
    $tail = substr($source, $afterParameters, 300);
    if (! preg_match('/^\s*:\s*([^\{=\r\n]+)/', $tail, $match)) {
        return 'Unit';
    }

    return trim($match[1]);
}

function functionBody(string $source, int $afterParameters): string
{
    $open = strpos($source, '{', $afterParameters);
    if ($open === false) {
        return '';
    }

    $depth = 0;
    $length = strlen($source);
    for ($index = $open; $index < $length; $index++) {
        if ($source[$index] === '{') {
            $depth++;
        } elseif ($source[$index] === '}') {
            $depth--;
            if ($depth === 0) {
                return substr($source, $open, $index - $open + 1);
            }
        }
    }

    return substr($source, $open);
}

function showFile(string $jvmPath, string $path): string
{
    return runGit($jvmPath, ['show', REFERENCE_TAG.':./'.$path]);
}

/** @param list<string> $arguments */
function runGit(string $jvmPath, array $arguments): string
{
    $command = 'git -C '.escapeshellarg($jvmPath);
    foreach ($arguments as $argument) {
        $command .= ' '.escapeshellarg($argument);
    }

    $output = shell_exec($command.' 2>/dev/null');
    if ($output === null) {
        fail('Git command failed in '.$jvmPath.': '.implode(' ', $arguments));
    }

    return $output;
}

/** @return list<string> */
function lines(string $output): array
{
    return array_values(array_filter(array_map('trim', preg_split('/\R/', $output) ?: [])));
}

/** @param array<string,mixed> $observed */
function operationCount(array $observed): int
{
    $count = 0;
    foreach ($observed['clients'] as $client) {
        $count += count($client['operations']);
    }

    return $count;
}

/** @param array<string,mixed> $observed */
function asyncOperationCount(array $observed): int
{
    $count = 0;
    foreach ($observed['clients'] as $client) {
        $count += count($client['asyncOperations']);
    }

    return $count;
}

function fail(string $message): never
{
    fwrite(STDERR, $message.PHP_EOL);
    exit(1);
}
