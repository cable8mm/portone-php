<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Tools\OpenApiDrift;

require_once __DIR__.'/OpenApiDrift.php';

$options = getopt('', ['current:', 'report:']);
$root = dirname(__DIR__);
$currentSource = $options['current'] ?? 'https://developers.portone.io/api/schema/v2/openapi.json';

if (str_starts_with($currentSource, 'https://')) {
    $handle = curl_init($currentSource);
    if ($handle === false) {
        fwrite(STDERR, "Could not initialize OpenAPI download.\n");
        exit(1);
    }

    curl_setopt_array($handle, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FAILONERROR => true,
        CURLOPT_USERAGENT => 'portone-php-openapi-drift-check',
    ]);
    $currentContents = curl_exec($handle);
    $curlError = curl_error($handle);
    $httpStatus = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
    unset($handle);

    if (! is_string($currentContents)) {
        fwrite(STDERR, 'Could not fetch the official OpenAPI document: '.$curlError."\n");
        exit(1);
    }
    if ($httpStatus < 200 || $httpStatus >= 300) {
        fwrite(STDERR, 'The OpenAPI server returned HTTP '.$httpStatus.".\n");
        exit(1);
    }
} else {
    $currentContents = file_get_contents($currentSource);
    if ($currentContents === false) {
        fwrite(STDERR, 'Could not read current OpenAPI document: '.$currentSource."\n");
        exit(1);
    }
}

$snapshotPath = $root.'/tests/fixtures/portone-v2-openapi.json';
$metadataPath = $root.'/tests/fixtures/portone-v2-openapi.meta.json';
$baseline = json_decode((string) file_get_contents($snapshotPath), true, 512, JSON_THROW_ON_ERROR);
$current = json_decode($currentContents, true, 512, JSON_THROW_ON_ERROR);
$metadata = json_decode((string) file_get_contents($metadataPath), true, 512, JSON_THROW_ON_ERROR);
$drift = OpenApiDrift::compare($baseline, $current);
$hasDrift = OpenApiDrift::hasDrift($drift);
$report = OpenApiDrift::markdown(
    $drift,
    is_string($metadata['retrievedAt'] ?? null) ? $metadata['retrievedAt'] : 'unknown',
    gmdate('Y-m-d H:i:s'),
);

if (isset($options['report'])) {
    if (file_put_contents($options['report'], $report) === false) {
        fwrite(STDERR, 'Could not write drift report: '.$options['report']."\n");
        exit(1);
    }
} else {
    echo $report;
}

if (($summaryPath = getenv('GITHUB_STEP_SUMMARY')) !== false
    && file_put_contents($summaryPath, $report, FILE_APPEND) === false) {
    fwrite(STDERR, "Could not append the drift report to the GitHub Actions summary.\n");
    exit(1);
}

if (($outputPath = getenv('GITHUB_OUTPUT')) !== false
    && file_put_contents($outputPath, 'has-drift='.($hasDrift ? 'true' : 'false')."\n", FILE_APPEND) === false) {
    fwrite(STDERR, "Could not write the drift result to GitHub Actions output.\n");
    exit(1);
}
