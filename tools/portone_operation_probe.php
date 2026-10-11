<?php

declare(strict_types=1);

use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\Future;
use Cable8mm\PortonePhp\PaymentClient;

require __DIR__.'/../vendor/autoload.php';

$apiSecret = getenv('PORTONE_API_SECRET');
if ($apiSecret === false || $apiSecret === '') {
    fwrite(STDERR, "PORTONE_API_SECRET is not set.\n");
    exit(1);
}

$client = new PaymentClient($apiSecret);
$page = ['number' => 0, 'size' => 1];

try {
    $sync = $client->getPayments($page);
    if (! is_array($sync->items) || ! is_array($sync->page)) {
        throw new RuntimeException('Synchronous result is not typed as expected.');
    }

    $future = $client->getPaymentsAsync($page);
    if (! $future instanceof Future) {
        throw new RuntimeException('Asynchronous operation did not return Future.');
    }
    $async = $future->wait();
    if (! is_array($async->items) || ! is_array($async->page)) {
        throw new RuntimeException('Asynchronous result is not typed as expected.');
    }

    echo json_encode([
        'status' => 'observed',
        'synchronousResultType' => $sync::class,
        'asynchronousResultType' => $async::class,
        'synchronousItemCount' => count($sync->items),
        'asynchronousItemCount' => count($async->items),
        'samePage' => $sync->page === $async->page,
        'requestsPerCall' => 1,
        'automaticRetry' => false,
    ], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;
} catch (PortOneException $exception) {
    fwrite(STDERR, json_encode([
        'status' => 'failed',
        'exception' => $exception::class,
        'portOneException' => true,
        'statusCode' => $exception->status,
    ], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL);
    exit(1);
}
