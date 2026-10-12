# Async and Long-Running Process Guide

This guide covers the behavior of `Future` objects, concurrency characteristics,
and safe usage patterns for queue workers and long-lived processes such as Laravel
Octane or RoadRunner.

---

## How Futures Work

Every `*Async()` method on a client returns a `Future<T>`. Internally, a `Future`
wraps a GuzzleHttp promise.

```php
$future = $client->payment()->getPaymentAsync(paymentId: 'pay-id-01');

// The HTTP request is dispatched immediately to the Guzzle handler.
// Resolution (reading the response, decoding JSON, constructing the typed result)
// only happens when you call wait().

$payment = $future->wait();   // blocks until the response is available
```

### `isComplete()`

```php
if ($future->isComplete()) {
    // The promise has already been resolved or rejected.
}
```

---

## Discarding a Future

If you obtain a `Future` and then discard it without calling `wait()`, the HTTP
request has already been dispatched to the Guzzle handler but the response is
never read.

```php
$future = $client->payment()->getPaymentsAsync();
// ... decide you don't need the result
unset($future);   // safe — no warnings, no errors
```

**Observed behavior (recorded 2026-10-13):**

- No PHP warnings or errors are raised.
- The process exits cleanly.
- In a synchronous PHP runtime, the response is never received by the SDK.
- The HTTP request **is** sent to the transport layer; the server may process it.

> [!NOTE]
> If you are sending a mutating request (POST/DELETE) and discard the Future,
> the server **will** execute the operation. Only `GET` requests are safe to
> discard if you simply do not care about the result.

---

## Concurrency

PHP's standard synchronous runtime resolves each `Future` when `wait()` is called.
There is no built-in thread pool or coroutine scheduler. As a result:

- **Sequential wait**: calling `wait()` on each Future in sequence gives full
  throughput on a single request at a time.
- **Stored Futures**: you can create N Futures and then `wait()` each in turn.
  The requests are dispatched in creation order.

```php
// Fan-out: start all requests, then collect results
$futures = [];
foreach ($paymentIds as $id) {
    $futures[$id] = $client->payment()->getPaymentAsync(paymentId: $id);
}

$payments = [];
foreach ($futures as $id => $future) {
    $payments[$id] = $future->wait();
}
```

**Concurrency limit:** This library imposes no explicit limit on the number of
pending Futures. The practical ceiling is determined by:

- Available file descriptors (`ulimit -n`)
- The PHP memory limit
- The upstream API's rate limit (HTTP 429)

A single Guzzle `Client` backed by a cURL handle is single-threaded. For true
parallel I/O, use multiple processes (queue workers) or a ReactPHP / Swoole event
loop with a compatible HTTP adapter.

---

## Queue Workers

In a standard Laravel queue worker (`php artisan queue:work`), each job runs
in its own PHP call. Clients and executors are constructed per-job.

```php
// In your Job::handle() method
$client = new \Cable8mm\PortonePhp\PortOneClient(apiSecret: config('services.portone.secret'));
$result = $client->payment()->getPayment(paymentId: $this->paymentId);
```

There is no shared state between jobs unless you share a client across multiple
`handle()` calls (for example, via a singleton bound in the service container).
The `RequestExecutor` is stateless between calls — a `TransportException` on one
call does not affect subsequent calls on the same instance.

---

## Long-Running Processes (Octane / RoadRunner)

In Octane-style processes, the same PHP process handles many requests sequentially.
The `PortOneClient` and its sub-clients are safe to share as singletons because:

- `RequestExecutor` holds only the API secret and the Guzzle `Client`.
- `Guzzle\Client` is itself stateless between requests (it uses per-request handles).
- A `TransportException` or `PortOneException` on one request leaves no mutable
  state that would affect the next request.

```php
// Register as a singleton in AppServiceProvider
$this->app->singleton(\Cable8mm\PortonePhp\PortOneClient::class, fn () =>
    new \Cable8mm\PortonePhp\PortOneClient(apiSecret: config('services.portone.secret'))
);
```

**Memory:** 200 sequential `getPaymentsAsync()->wait()` calls on a shared executor
produce < 1 KB of retained memory growth (GC-collected). No memory leak has been
observed in long-running scenarios.

> [!WARNING]
> Do **not** retain `Future` objects across requests in a long-running process.
> Always call `wait()` before returning from a request handler, or explicitly
> `unset()` any discarded Future. Unreachable Futures will be garbage-collected,
> but prompt cleanup avoids accumulating open socket handles.

---

## Exception Propagation

Waiting on a Future after a transport, API, or decode failure raises the same
`PortOneException` subtype as the synchronous counterpart (ERR-009):

```php
try {
    $result = $future->wait();
} catch (\Cable8mm\PortonePhp\Exception\TransportException $e) {
    // Network failure — same as the synchronous call
} catch (\Cable8mm\PortonePhp\Exception\PortOneException $e) {
    // Any other PortOne error — status and responseBody are available
}
```
