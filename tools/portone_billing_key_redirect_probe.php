<?php

declare(strict_types=1);

// Live observation of the browser SDK billing-key issuance redirect (T-066).
// Run as the PHP built-in server's router from the package root:
//   php -S localhost:8766 tools/portone_billing_key_redirect_probe.php
// Open http://localhost:8766/, run one issuance to success and one to failure.
// Each redirect query is recorded with the billing key redacted; an issued
// billing key is looked up and deleted at once with the PHP client.

use Cable8mm\PortonePhp\Client\BillingKeyClient;
use Cable8mm\PortonePhp\Exception\PortOneException;
use Dotenv\Dotenv;

$root = dirname(__DIR__);
require $root.'/vendor/autoload.php';
Dotenv::createImmutable($root)->safeLoad();

const SDK_VERSION = '0.1.13';
const OBSERVATION_PATH = __DIR__.'/../tests/fixtures/billing-key-redirect-boundary-observations.json';

function env(string $name): string
{
    $value = $_ENV[$name] ?? '';

    return is_string($value) ? $value : '';
}

/** @return array<string,mixed> */
function readObservation(): array
{
    if (! is_file(OBSERVATION_PATH)) {
        return [];
    }
    $decoded = json_decode((string) file_get_contents(OBSERVATION_PATH), true);

    return is_array($decoded) ? $decoded : [];
}

/** @param array<string,mixed> $run */
function recordRun(string $scenario, array $run): void
{
    $observation = readObservation() + [
        'task' => 'T-066',
        'browserSdk' => '@portone/browser-sdk '.SDK_VERSION,
        'request' => ['billingKeyMethod' => 'CARD', 'forceRedirect' => true],
        'secretsRecorded' => false,
        'runs' => [],
    ];
    $observation['runs'][$scenario] = ['observedAt' => gmdate(DATE_ATOM)] + $run;
    file_put_contents(
        OBSERVATION_PATH,
        json_encode($observation, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR).PHP_EOL,
        LOCK_EX,
    );
}

/** @return array<string,mixed> */
function exceptionRecord(Throwable $exception): array
{
    return [
        'result' => 'error',
        'exception' => $exception::class,
        'httpStatus' => $exception instanceof PortOneException ? $exception->status : null,
        'errorType' => $exception instanceof PortOneException ? $exception->errorType : null,
    ];
}

$path = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$storeId = env('PORTONE_E2E_STORE_ID') !== '' ? env('PORTONE_E2E_STORE_ID') : env('STORE_ID');
$channelKey = env('PORTONE_E2E_CHANNEL_KEY');
$apiSecret = env('PORTONE_API_SECRET');

if ($storeId === '' || $channelKey === '' || $apiSecret === '') {
    http_response_code(503);
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'PORTONE_API_SECRET, PORTONE_E2E_STORE_ID (or STORE_ID), and PORTONE_E2E_CHANNEL_KEY must be set in .env.';

    return;
}

if (preg_match('#^/redirect/(success|failure)$#', $path, $match) === 1) {
    $scenario = $match[1];
    $rawQuery = (string) ($_SERVER['QUERY_STRING'] ?? '');
    parse_str($rawQuery, $query);
    $billingKey = is_string($query['billingKey'] ?? null) ? $query['billingKey'] : null;

    $redacted = $query;
    if (array_key_exists('billingKey', $redacted)) {
        $redacted['billingKey'] = '[redacted]';
    }

    $run = [
        'source' => 'redirect query received by redirectUrl',
        'queryKeys' => array_keys($query),
        'query' => $redacted,
    ];

    if ($billingKey !== null && $billingKey !== '') {
        $client = new BillingKeyClient($apiSecret);
        try {
            $info = $client->getBillingKeyInfo($billingKey, $storeId);
            $run['lookup'] = ['result' => 'success', 'model' => $info::class, 'variant' => $info->variant ?? null];
        } catch (Throwable $exception) {
            $run['lookup'] = exceptionRecord($exception);
        }
        try {
            $deleted = $client->deleteBillingKey($billingKey, 'T-066 probe cleanup', null, null, $storeId);
            $run['deletion'] = ['result' => 'success', 'model' => $deleted::class];
        } catch (Throwable $exception) {
            $run['deletion'] = exceptionRecord($exception);
        }
    }

    recordRun($scenario, $run);
    header('Cache-Control: no-store');
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!doctype html><meta charset="utf-8"><title>Billing-key redirect recorded</title>';
    echo '<h1>Recorded: '.htmlspecialchars($scenario).'</h1><pre>'
        .htmlspecialchars(json_encode($run, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR))
        .'</pre><p><a href="/">Back</a></p>';

    return;
}

if ($path === '/observe') {
    // The SDK promise result, when the SDK resolves instead of redirecting.
    $body = json_decode((string) file_get_contents('php://input'), true);
    if (is_array($body) && in_array($body['scenario'] ?? null, ['success', 'failure'], true)) {
        $result = is_array($body['result'] ?? null) ? $body['result'] : null;
        if (is_array($result) && array_key_exists('billingKey', $result)) {
            $result['billingKey'] = '[redacted]';
        }
        recordRun($body['scenario'].'-sdk-result', ['source' => 'requestIssueBillingKey promise', 'result' => $result, 'error' => $body['error'] ?? null]);
    }
    http_response_code(204);

    return;
}

if ($path !== '/') {
    http_response_code(404);

    return;
}

header('Cache-Control: no-store');
header('Content-Type: text/html; charset=UTF-8');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Billing-key redirect probe</title>
</head>
<body>
    <main>
        <h1>PortOne billing-key issuance redirect probe (T-066)</h1>
        <p>Success run: complete the card registration in the PG window. Failure run: close the window or let the card be refused.</p>
        <button id="success" type="button">Issue billing key (complete)</button>
        <button id="failure" type="button">Issue billing key (close or refuse)</button>
        <pre id="status" aria-live="polite"></pre>
    </main>
    <script id="portone-config" type="application/json"><?= json_encode(
        ['storeId' => $storeId, 'channelKey' => $channelKey],
        JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR,
    ) ?></script>
    <script type="module">
        import PortOne from "https://cdn.jsdelivr.net/npm/@portone/browser-sdk@<?= SDK_VERSION ?>/+esm";

        const config = JSON.parse(document.querySelector("#portone-config").textContent);
        const status = document.querySelector("#status");

        async function issue(scenario) {
            const issueId = "bk" + crypto.randomUUID().replaceAll("-", "").slice(0, 24);
            status.textContent = `Requesting ${scenario} (${issueId})…`;
            let result = null;
            let error = null;
            try {
                result = await PortOne.requestIssueBillingKey({
                    storeId: config.storeId,
                    channelKey: config.channelKey,
                    billingKeyMethod: "CARD",
                    issueId,
                    issueName: "T-066 probe",
                    customer: {
                        customerId: "probe-customer",
                        fullName: "Probe Tester",
                        phoneNumber: "01000000000",
                        email: "probe@example.com",
                    },
                    redirectUrl: `${location.origin}/redirect/${scenario}`,
                    forceRedirect: true,
                });
            } catch (e) {
                error = { name: e?.name ?? null, code: e?.code ?? null, message: String(e?.message ?? e) };
            }
            const shown = result && "billingKey" in result ? { ...result, billingKey: "[redacted]" } : result;
            status.textContent = JSON.stringify({ result: shown, error }, null, 2);
            await fetch("/observe", { method: "POST", body: JSON.stringify({ scenario, result, error }) });
        }

        document.querySelector("#success").addEventListener("click", () => issue("success"));
        document.querySelector("#failure").addEventListener("click", () => issue("failure"));
    </script>
</body>
</html>
