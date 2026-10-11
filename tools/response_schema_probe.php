<?php

declare(strict_types=1);

use Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

/**
 * Compares generated JVM response model fields with PHP response classes.
 *
 * Usage:
 *   php tools/response_schema_probe.php
 *   php tools/response_schema_probe.php --verify-record
 *   php tools/response_schema_probe.php --compare-php
 */
const REFERENCE_TAG = 'jvm-v0.24.0';
const RECORD_PATH = __DIR__.'/../tests/fixtures/jvm-v0.24.0-response-schema.json';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();
if (isset($_ENV['PORTONE_JVM_PATH']) && getenv('PORTONE_JVM_PATH') === false) {
    putenv('PORTONE_JVM_PATH='.$_ENV['PORTONE_JVM_PATH']);
}

$jvmPath = getenv('PORTONE_JVM_PATH');
if ($jvmPath === false || $jvmPath === '') {
    fail('PORTONE_JVM_PATH is not set. Add the local JVM SDK path to .env.');
}
if (! is_dir($jvmPath)) {
    fail('PORTONE_JVM_PATH is not a directory: '.$jvmPath);
}

$mode = $argv[1] ?? 'compare-php';
$mode = $mode === '--compare-php' ? 'compare-php' : $mode;
$schema = observeResponseSchema($jvmPath);

if ($mode === 'record') {
    writeJson(RECORD_PATH, $schema);
    echo 'Recorded '.count($schema['models'])." JVM response models.\n";
    exit(0);
}

if (! is_file(RECORD_PATH)) {
    fail('Record does not exist: '.RECORD_PATH.'; run with "record" first.');
}

$recorded = json_decode((string) file_get_contents(RECORD_PATH), true, 512, JSON_THROW_ON_ERROR);

if ($mode === 'verify-record') {
    if ($recorded !== $schema) {
        fail('The JVM response schema differs from the recorded schema.');
    }

    echo "Recorded JVM response schema is reproducible.\n";
    exit(0);
}

if ($mode !== 'compare-php') {
    fail('Unknown mode: '.$mode);
}

$report = comparePhpResponses($recorded['models']);
echo json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL;

if ($report['summary']['mismatched'] > 0) {
    exit(1);
}

/** @return array{reference:array{tag:string,commit:string},models:array<string,array{path:string,kind:string,fields:array<string,string>,variants:list<string>}>} */
function observeResponseSchema(string $jvmPath): array
{
    $commit = trim(runGit($jvmPath, ['rev-parse', REFERENCE_TAG]));
    $paths = lines(runGit($jvmPath, [
        'ls-tree', '-r', '--name-only', REFERENCE_TAG, '--',
        'lib/src/generated/kotlin/io/portone/sdk/server',
    ]));
    $models = [];

    foreach ($paths as $path) {
        if (! str_ends_with($path, '.kt')) {
            continue;
        }

        $source = showFile($jvmPath, $path);
        $declarations = parseDeclarations($source);
        foreach ($declarations as $declaration) {
            if (! str_ends_with($declaration['name'], 'Response')) {
                continue;
            }

            $models[$declaration['name']] = [
                'path' => $path,
                'kind' => $declaration['kind'],
                'fields' => $declaration['fields'],
                'variants' => $declaration['variants'],
            ];
        }
    }

    ksort($models);

    return [
        'reference' => ['tag' => REFERENCE_TAG, 'commit' => $commit],
        'models' => $models,
    ];
}

/** @return list<array{name:string,kind:string,fields:array<string,string>,variants:list<string>}> */
function parseDeclarations(string $source): array
{
    $declarations = [];
    preg_match_all(
        '/public\s+(?:(?:sealed|data)\s+)*(class|interface|object|enum\s+class)\s+([A-Za-z_]\w*)/',
        $source,
        $matches,
        PREG_OFFSET_CAPTURE,
    );

    foreach ($matches[2] ?? [] as $index => [$name, $offset]) {
        $kind = $matches[1][$index][0];
        $afterName = $offset + strlen($name);
        $fields = [];
        $variants = [];
        $openCharacter = in_array($kind, ['interface', 'object', 'enum class'], true) ? '{' : '(';
        $open = strpos($source, $openCharacter, $afterName);

        if ($open === false) {
            if ($kind === 'object') {
                $declarations[] = compact('name', 'kind', 'fields', 'variants');
            }

            continue;
        }

        if ($kind === 'class' && str_contains(substr($source, max(0, $offset - 20), 30), 'data class')) {
            [$body] = balanced($source, $open, '(', ')');
            $fields = parseFields($body);
        } elseif ($kind === 'interface') {
            [$body] = balanced($source, $open, '{', '}');
            $fields = parseFields($body);
        } elseif ($kind === 'enum class') {
            [$body] = balanced($source, $open, '{', '}');
            $variants = parseEnumVariants($body);
        }

        $declarations[] = compact('name', 'kind', 'fields', 'variants');
    }

    return $declarations;
}

/** @return array{0:string,1:int} */
function balanced(string $source, int $open, string $openCharacter, string $closeCharacter): array
{
    $depth = 0;
    $length = strlen($source);
    for ($index = $open; $index < $length; $index++) {
        if ($source[$index] === $openCharacter) {
            $depth++;
        } elseif ($source[$index] === $closeCharacter) {
            $depth--;
            if ($depth === 0) {
                return [substr($source, $open + 1, $index - $open - 1), $index + 1];
            }
        }
    }

    fail('Unbalanced Kotlin declaration.');
}

/** @return array<string,string> */
function parseFields(string $body): array
{
    $fields = [];
    foreach (preg_split('/\R/', $body) ?: [] as $line) {
        $line = trim(preg_replace('/\/\/.*$/', '', $line) ?? $line);
        if (preg_match('/^(?:public\s+)?val\s+(`[^`]+`|[A-Za-z_]\w*)\s*:\s*(.+?)(?:\s*=.*)?[,]?$/', $line, $match)) {
            $name = trim($match[1], '`');
            $fields[$name] = normalizeKotlinType($match[2]);
        }
    }

    ksort($fields);

    return $fields;
}

function normalizeKotlinType(string $type): string
{
    $type = preg_replace('/@[A-Za-z_]\w*(?:\([^)]*\))?\s*/', '', $type) ?? $type;

    return trim($type, " \t,");
}

/** @return list<string> */
function parseEnumVariants(string $body): array
{
    $body = preg_split('/;/', $body, 2)[0] ?? $body;
    preg_match_all('/\b([A-Z][A-Z0-9_]*)\b/', $body, $matches);
    $variants = array_values(array_unique($matches[1] ?? []));
    sort($variants);

    return $variants;
}

/** @param array<string,array{path:string,kind:string,fields:array<string,string>,variants:list<string>}> $models */
function comparePhpResponses(array $models): array
{
    $php = [];
    foreach (glob(dirname(__DIR__).'/src/Response/*.php') ?: [] as $path) {
        $source = (string) file_get_contents($path);
        if (! preg_match('/final class\s+([A-Za-z_]\w*)/', $source, $class)) {
            continue;
        }

        $fields = [];
        preg_match_all('/public\s+readonly\s+([^$\s]+)\s+\$([A-Za-z_]\w*)/', $source, $properties, PREG_SET_ORDER);
        foreach ($properties as $property) {
            $fields[$property[2]] = $property[1];
        }
        ksort($fields);
        $php[$class[1]] = [
            'path' => $path,
            'fields' => $fields,
            'rawData' => str_contains($source, 'extends OperationResponse')
                && $fields === []
                && ! str_contains($source, 'public static function fromArray'),
        ];
    }

    $report = ['summary' => ['models' => count($models), 'matched' => 0, 'mismatched' => 0], 'models' => []];
    foreach ($models as $name => $model) {
        $actual = $php[$name] ?? null;
        $expectedFields = array_keys($model['fields']);
        $actualFields = array_keys($actual['fields'] ?? []);
        $missing = array_values(array_diff($expectedFields, $actualFields));
        $unexpected = array_values(array_diff($actualFields, $expectedFields));
        $status = $actual !== null && ! $actual['rawData'] && $missing === [] && $unexpected === [] ? 'match' : 'mismatch';
        $report['models'][$name] = [
            'status' => $status,
            'jvm' => ['path' => $model['path'], 'fields' => $model['fields'], 'variants' => $model['variants']],
            'php' => $actual === null ? null : [
                'path' => $actual['path'],
                'fields' => $actual['fields'],
                'rawData' => $actual['rawData'],
            ],
            'missingFields' => $missing,
            'unexpectedFields' => $unexpected,
            'rawDataWrapper' => $actual['rawData'] ?? false,
        ];
        if ($status === 'match') {
            $report['summary']['matched']++;
        } else {
            $report['summary']['mismatched']++;
        }
    }

    return $report;
}

function writeJson(string $path, array $data): void
{
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL;
    if (file_put_contents($path, $json) === false) {
        fail('Could not write record: '.$path);
    }
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

function fail(string $message): never
{
    fwrite(STDERR, $message.PHP_EOL);
    exit(1);
}
