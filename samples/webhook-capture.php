<?php

declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    header('Content-Type: text/plain; charset=utf-8');
    echo "POST only\n";
    exit;
}

$headers = function_exists('getallheaders') ? getallheaders() : [];
$normalizedHeaders = [];
foreach ($headers as $name => $value) {
    $normalizedHeaders[strtolower($name)] = (string) $value;
}

$requiredHeaders = ['webhook-id', 'webhook-signature', 'webhook-timestamp'];
foreach ($requiredHeaders as $name) {
    if (! isset($normalizedHeaders[$name]) || $normalizedHeaders[$name] === '') {
        http_response_code(400);
        header('Content-Type: text/plain; charset=utf-8');
        echo "Missing required webhook header\n";
        exit;
    }
}

$record = [
    'body' => file_get_contents('php://input'),
    'headers' => [
        'webhook-id' => $normalizedHeaders['webhook-id'],
        'webhook-signature' => $normalizedHeaders['webhook-signature'],
        'webhook-timestamp' => $normalizedHeaders['webhook-timestamp'],
    ],
];

$recordPath = __DIR__.'/../tests/fixtures/live-webhook.json';
$recordJson = json_encode($record, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL;
if (file_put_contents($recordPath, $recordJson, LOCK_EX) === false) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Could not save webhook capture\n";
    exit;
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode(['ok' => true], JSON_THROW_ON_ERROR).PHP_EOL;
