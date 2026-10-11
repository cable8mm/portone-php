<?php

declare(strict_types=1);

use Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

$root = dirname(__DIR__);
$dotenv = Dotenv::createImmutable($root);
$dotenv->safeLoad();

foreach (['PORTONE_API_SECRET', 'PORTONE_WEBHOOK_SECRET'] as $name) {
    if (isset($_ENV[$name])) {
        putenv($name.'='.$_ENV[$name]);
    }
}

foreach (['PORTONE_API_SECRET', 'PORTONE_WEBHOOK_SECRET'] as $name) {
    if (getenv($name) === false || getenv($name) === '') {
        fwrite(STDERR, $name.' is not set. Copy .env.example to .env and fill in test credentials.'.PHP_EOL);
        exit(1);
    }
}

$probes = [
    'tools/portone_boundary_probe.php',
    'tools/portone_operation_probe.php',
    'tools/portone_auth_probe.php',
    'tools/portone_payment_operations_probe.php',
    'tools/portone_identity_verification_probe.php',
    'tools/portone_pg_specific_probe.php',
    'tools/portone_reconciliation_probe.php',
    'tools/portone_platform_core_probe.php',
    'tools/portone_platform_bulk_payout_probe.php',
    'tools/portone_platform_partner_transfer_probe.php',
    'tools/portone_policy_probe.php',
    'tools/portone_tax_invoice_probe.php',
    'tools/portone_counterparty_probe.php',
    'tools/portone_openapi_additions_probe.php',
    'tools/portone_openapi_matrix_probe.php',
    'tools/portone_webhook_probe.php',
];

foreach ($probes as $probe) {
    echo PHP_EOL.'=== '.$probe.' ==='.PHP_EOL;
    $pipes = [];
    $process = proc_open(
        [PHP_BINARY, $root.'/'.$probe],
        [1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
        $pipes,
        $root,
    );

    if (! is_resource($process)) {
        fwrite(STDERR, 'Could not start '.$probe.'.'.PHP_EOL);
        exit(1);
    }

    $stdout = stream_get_contents($pipes[1]);
    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    $exitCode = proc_close($process);

    echo $stdout;
    if ($stderr !== '') {
        fwrite(STDERR, $stderr);
    }
    if ($exitCode !== 0) {
        exit($exitCode);
    }
}
