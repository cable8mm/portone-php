<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

require __DIR__.'/../vendor/autoload.php';

$apiSecret = getenv('PORTONE_API_SECRET');
$webhookSecret = getenv('PORTONE_WEBHOOK_SECRET');

if ($apiSecret === false || $apiSecret === '') {
    fail('PORTONE_API_SECRET is not set.');
}

if ($webhookSecret === false || $webhookSecret === '') {
    fail('PORTONE_WEBHOOK_SECRET is not set.');
}

$client = new Client([
    'base_uri' => 'https://api.portone.io',
    'connect_timeout' => 10,
    'timeout' => 30,
    'http_errors' => false,
]);

$observations = [
    'boundary' => 'https://api.portone.io',
    'observedAt' => gmdate(DATE_ATOM),
    'api' => [],
    'transport' => [],
    'webhook' => webhookObservation($webhookSecret),
];

$headers = [
    'Authorization' => 'PortOne '.$apiSecret,
    'Accept' => 'application/json',
];

$requestBody = json_encode([
    'page' => [
        'number' => 0,
        'size' => 1,
    ],
], JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);

$observations['api']['representativeSuccess'] = requestObservation(
    $client,
    'GET',
    '/payments',
    [
        'headers' => $headers,
        'query' => ['requestBody' => $requestBody],
    ],
);

$observations['api']['definedError'] = requestObservation(
    $client,
    'GET',
    '/payments/__codex_t003_missing_payment__',
    ['headers' => $headers],
);

$observations['api']['unknownError'] = requestObservation(
    $client,
    'GET',
    '/__codex_t003_unknown_operation__',
    ['headers' => $headers],
);

$observations['transport']['timeout'] = timeoutObservation($headers);

$observations['transport']['connectionFailure'] = transportObservation($client);

$recordPath = __DIR__.'/../tests/fixtures/portone-v2-boundary-observations.json';
$json = json_encode($observations, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL;
if (file_put_contents($recordPath, $json) === false) {
    fail('Could not write observation record.');
}

echo json_encode($observations, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL;

if ($observations['webhook']['status'] !== 'observed') {
    fail('The live webhook boundary was not observed; T-003 is incomplete.');
}

/** @return array<string,mixed> */
function requestObservation(Client $client, string $method, string $uri, array $options): array
{
    try {
        $response = $client->request($method, $uri, $options);
        $body = (string) $response->getBody();
        $decoded = json_decode($body, true);

        return [
            'status' => $response->getStatusCode(),
            'json' => is_array($decoded),
            'topLevelKeys' => is_array($decoded) ? sortedKeys($decoded) : [],
            'errorType' => is_array($decoded) && is_string($decoded['type'] ?? null) ? $decoded['type'] : null,
            'hasMessage' => is_array($decoded) && array_key_exists('message', $decoded),
        ];
    } catch (GuzzleException $exception) {
        return [
            'status' => 'transport-failure',
            'exception' => $exception::class,
        ];
    }
}

/** @return array<string,mixed> */
function transportObservation(Client $client): array
{
    try {
        $client->request('GET', 'http://127.0.0.1:9', [
            'connect_timeout' => 1,
            'timeout' => 1,
            'http_errors' => false,
        ]);

        return ['status' => 'unexpected-response'];
    } catch (GuzzleException $exception) {
        return [
            'status' => 'transport-failure',
            'exception' => $exception::class,
        ];
    }
}

/** @param array<string,string> $headers */
function timeoutObservation(array $headers): array
{
    $client = new Client([
        'base_uri' => 'https://api.portone.io',
        'http_errors' => false,
        'connect_timeout' => 10,
        'timeout' => 0.001,
    ]);

    try {
        $response = $client->request('GET', '/payments', [
            'headers' => $headers,
            'query' => ['requestBody' => '{"page":{"number":0,"size":1}}'],
        ]);

        return [
            'status' => 'unexpected-response',
            'httpStatus' => $response->getStatusCode(),
        ];
    } catch (GuzzleException $exception) {
        return [
            'status' => 'transport-failure',
            'exception' => $exception::class,
            'timeoutSeconds' => 0.001,
        ];
    }
}

/** @return array<string,mixed> */
function webhookObservation(string $secret): array
{
    $capturePath = __DIR__.'/../tests/fixtures/live-webhook.json';
    if (! is_file($capturePath)) {
        return [
            'status' => 'blocked',
            'reason' => 'No captured PortOne webhook body and headers were provided for a live verification probe.',
        ];
    }

    $capture = json_decode((string) file_get_contents($capturePath), true, 512, JSON_THROW_ON_ERROR);
    $body = $capture['body'] ?? null;
    $headers = $capture['headers'] ?? null;
    if (! is_string($body) || ! is_array($headers)) {
        return ['status' => 'failed', 'reason' => 'Webhook capture has an invalid shape.'];
    }

    $verified = verifyWebhook($secret, $body, $headers);
    if (! $verified['valid']) {
        return ['status' => 'failed', 'reason' => $verified['reason']];
    }

    $payload = json_decode($body, true);
    $bodyMutation = verifyWebhook($secret, $body.' ', $headers);
    $signatureMutation = $headers;
    $signatureMutation['webhook-signature'] = 'v1,'.base64_encode(random_bytes(32));
    $signatureMutationResult = verifyWebhook($secret, $body, $signatureMutation);
    $unknownTypeResult = ['valid' => false];
    if (is_array($payload)) {
        $payload['type'] = 'Codex.UnknownWebhook';
        $unknownBody = json_encode($payload, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
        $unknownHeaders = $headers;
        $unknownHeaders['webhook-signature'] = 'v1,'.base64_encode(
            hash_hmac(
                'sha256',
                $unknownHeaders['webhook-id'].'.'.$unknownHeaders['webhook-timestamp'].'.'.$unknownBody,
                webhookKey($secret),
                true,
            ),
        );
        $unknownTypeResult = verifyWebhook($secret, $unknownBody, $unknownHeaders);
    }

    return [
        'status' => 'observed',
        'validSignature' => true,
        'timestampWithinTolerance' => $verified['timestampWithinTolerance'],
        'knownTypePayloadPresent' => is_array($payload) && is_string($payload['type'] ?? null),
        'unknownTypeAcceptedWithLiveSignatureRule' => $unknownTypeResult['valid'] ?? false,
        'bodyMutationRejected' => ! $bodyMutation['valid'],
        'signatureMutationRejected' => ! $signatureMutationResult['valid'],
    ];
}

/** @return array{valid:bool, timestampWithinTolerance:bool, reason?:string} */
function verifyWebhook(string $secret, string $body, array $headers): array
{
    $id = $headers['webhook-id'] ?? '';
    $timestamp = $headers['webhook-timestamp'] ?? '';
    $signatures = $headers['webhook-signature'] ?? '';
    if (! is_string($id) || ! is_string($timestamp) || ! is_string($signatures) || $id === '' || $timestamp === '' || $signatures === '') {
        return ['valid' => false, 'timestampWithinTolerance' => false, 'reason' => 'Missing required headers.'];
    }

    if (! ctype_digit($timestamp)) {
        return ['valid' => false, 'timestampWithinTolerance' => false, 'reason' => 'Invalid timestamp.'];
    }

    $timestampWithinTolerance = abs(time() - (int) $timestamp) <= 300;
    if (! $timestampWithinTolerance) {
        return ['valid' => false, 'timestampWithinTolerance' => false, 'reason' => 'Timestamp outside tolerance.'];
    }

    try {
        $key = webhookKey($secret);
    } catch (InvalidArgumentException) {
        return ['valid' => false, 'timestampWithinTolerance' => true, 'reason' => 'Webhook secret is not valid Base64.'];
    }

    $expected = hash_hmac('sha256', $id.'.'.$timestamp.'.'.$body, $key, true);
    foreach (explode(' ', $signatures) as $versionedSignature) {
        [$version, $encodedSignature] = array_pad(explode(',', $versionedSignature, 2), 2, '');
        $signature = base64_decode($encodedSignature, true);
        if ($version === 'v1' && $signature !== false && hash_equals($expected, $signature)) {
            return ['valid' => true, 'timestampWithinTolerance' => true];
        }
    }

    return ['valid' => false, 'timestampWithinTolerance' => true, 'reason' => 'No matching signature.'];
}

function webhookKey(string $secret): string
{
    $encodedKey = str_starts_with($secret, 'whsec_') ? substr($secret, 6) : $secret;
    $key = base64_decode($encodedKey, true);
    if ($key === false || $key === '') {
        throw new InvalidArgumentException('Webhook secret is not valid Base64.');
    }

    return $key;
}

/** @param array<string,mixed> $values */
function sortedKeys(array $values): array
{
    $keys = array_keys($values);
    sort($keys);

    return $keys;
}

function fail(string $message): never
{
    fwrite(STDERR, $message.PHP_EOL);
    exit(1);
}
