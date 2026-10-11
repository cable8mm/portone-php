<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Exception\WebhookVerificationException;
use Cable8mm\PortonePhp\UnrecognizedWebhook;
use Cable8mm\PortonePhp\WebhookTransactionPaid;
use Cable8mm\PortonePhp\WebhookVerifier;

require __DIR__.'/../vendor/autoload.php';

$secret = getenv('PORTONE_WEBHOOK_SECRET');
if ($secret === false || $secret === '') {
    fwrite(STDERR, "PORTONE_WEBHOOK_SECRET is not set.\n");
    exit(1);
}

$capture = json_decode((string) file_get_contents(__DIR__.'/../tests/fixtures/live-webhook.json'), true, 512, JSON_THROW_ON_ERROR);
$body = $capture['body'];
$headers = $capture['headers'];
$verifier = new WebhookVerifier($secret);
$freshTimestamp = (string) time();
$encodedSecret = str_starts_with($secret, 'whsec_') ? substr($secret, 6) : $secret;
$secretBytes = base64_decode($encodedSecret, true);
if ($secretBytes === false || $secretBytes === '') {
    fwrite(STDERR, "PORTONE_WEBHOOK_SECRET is not valid Base64.\n");
    exit(1);
}
$freshSignature = static function (string $signedBody) use ($headers, $freshTimestamp, $secretBytes): string {
    return 'v1,'.base64_encode(hash_hmac('sha256', $headers['webhook-id'].'.'.$freshTimestamp.'.'.$signedBody, $secretBytes, true));
};
$freshHeaders = [
    'webhook-id' => $headers['webhook-id'],
    'webhook-signature' => $freshSignature($body),
    'webhook-timestamp' => $freshTimestamp,
];
$observations = [];

try {
    $known = $verifier->verify($body, $freshHeaders['webhook-id'], $freshHeaders['webhook-signature'], $freshHeaders['webhook-timestamp']);
    $observations['known'] = [
        'status' => 'success',
        'resultType' => $known::class,
        'isExpectedType' => $known instanceof WebhookTransactionPaid,
    ];
} catch (WebhookVerificationException $exception) {
    $observations['known'] = ['status' => 'failure', 'exception' => $exception::class];
}

$decoded = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
$decoded['type'] = 'Future.LiveEvent';
$unknownBody = json_encode($decoded, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);
$unknownSignature = $freshSignature($unknownBody);

try {
    $unknown = $verifier->verify($unknownBody, $freshHeaders['webhook-id'], $unknownSignature, $freshHeaders['webhook-timestamp']);
    $observations['unknown'] = [
        'status' => 'success',
        'resultType' => $unknown::class,
        'isExpectedType' => $unknown instanceof UnrecognizedWebhook,
    ];
} catch (WebhookVerificationException $exception) {
    $observations['unknown'] = ['status' => 'failure', 'exception' => $exception::class];
}

foreach ([
    'bodyMutation' => [$body.' ', $freshHeaders['webhook-signature']],
    'signatureMutation' => [$body, $freshHeaders['webhook-signature'].'x'],
] as $name => [$mutatedBody, $mutatedSignature]) {
    try {
        $verifier->verify($mutatedBody, $freshHeaders['webhook-id'], $mutatedSignature, $freshHeaders['webhook-timestamp']);
        $observations[$name] = ['status' => 'unexpected-success'];
    } catch (WebhookVerificationException $exception) {
        $observations[$name] = ['status' => 'rejected', 'exception' => $exception::class];
    }
}

$output = ['status' => 'observed', 'observations' => $observations];
$recordPath = __DIR__.'/../tests/fixtures/webhook-boundary-observations.json';
if (file_put_contents($recordPath, json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL) === false) {
    fwrite(STDERR, "Could not write webhook observations.\n");
    exit(1);
}

echo json_encode($output, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;
