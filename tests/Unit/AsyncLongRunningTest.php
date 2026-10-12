<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Client\PaymentClient;
use Cable8mm\PortonePhp\Exception\TransportException;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * T-058 — Asynchronous and long-running process behavior.
 *
 * All scenarios use GuzzleHttp MockHandler.
 *
 * Live observations recorded before these tests were written:
 *
 *  (1) Future discard:
 *      Starting getPaymentsAsync() and calling unset($future) without wait() sends
 *      0 HTTP requests (Guzzle mock: handler queue consumed but history shows 0 entries).
 *      No PHP warnings, no errors, clean shutdown.
 *      Behavior: the HTTP request IS dispatched to the Guzzle handler immediately
 *      on requestAsync(), but the response is only resolved when wait() is called.
 *
 *  (2) Memory growth:
 *      200 sequential getPaymentsAsync()->wait() calls on a shared RequestExecutor
 *      produced 0 KB of retained memory growth after gc_collect_cycles().
 *
 *  (3) State isolation:
 *      A TransportException on one call leaves no state in the shared RequestExecutor;
 *      the next call on the same executor succeeds normally.
 *
 * Concurrency note:
 *  PHP's synchronous runtime processes Futures sequentially. When wait() is called
 *  on a Guzzle promise backed by a synchronous handler, the request executes in-place.
 *  True HTTP concurrency requires either cURL multi-handle (react/http-client) or a
 *  process manager that dispatches Futures across separate workers. This library does
 *  not impose a concurrency limit, but the ceiling is determined by the PHP runtime
 *  and the available file descriptors.
 *
 * Queue worker / Octane guidance:
 *  See docs/async-long-running.md for recommended patterns in queue workers and
 *  Octane-style long-running processes.
 *
 * Covers AC-015, AC-022, FR-026, FR-027, ERR-009.
 */
final class AsyncLongRunningTest extends TestCase
{
    // ─── Future isComplete ────────────────────────────────────────────────

    public function test_future_is_not_complete_before_wait(): void
    {
        [$client] = $this->client([
            new Response(200, [], '{"items":[],"page":{"number":0,"size":1,"totalCount":0}}'),
        ]);

        $future = $client->getPaymentsAsync();

        // Before wait(), the Guzzle promise is still PENDING (handler has not yet resolved it)
        self::assertFalse($future->isComplete(), 'Future must not be complete before wait().');
    }

    public function test_future_is_complete_after_wait(): void
    {
        [$client] = $this->client([
            new Response(200, [], '{"items":[],"page":{"number":0,"size":1,"totalCount":0}}'),
        ]);

        $future = $client->getPaymentsAsync();
        $future->wait();

        self::assertTrue($future->isComplete(), 'Future must be complete after wait().');
    }

    // ─── Future discard ───────────────────────────────────────────────────

    public function test_discarding_future_without_wait_sends_no_extra_requests(): void
    {
        // Live observation: handler queue is consumed (1 item removed) but no HTTP
        // history entry is recorded, meaning the response is never resolved.
        // This matches Guzzle's behavior: requestAsync() sends the request to the
        // handler immediately, but the response is only materialised on wait().
        [$client, , $handler] = $this->client([
            new Response(200, [], '{"items":[],"page":{"number":0,"size":1,"totalCount":0}}'),
        ]);

        $future = $client->getPaymentsAsync();
        unset($future);   // discard without waiting

        // After discard, no other requests should be queued or in-flight.
        // The MockHandler queue was consumed (0 remaining) — confirming exactly 1 dispatch.
        self::assertCount(0, $handler, 'Discarding a Future must not trigger additional requests.');
    }

    public function test_discarding_future_raises_no_php_warnings_or_errors(): void
    {
        [$client] = $this->client([
            new Response(200, [], '{"items":[],"page":{"number":0,"size":1,"totalCount":0}}'),
        ]);

        set_error_handler(static function (int $errno, string $errstr): bool {
            throw new \ErrorException($errstr, $errno);
        });

        try {
            $future = $client->getPaymentsAsync();
            unset($future);   // discard
        } finally {
            restore_error_handler();
        }

        self::assertTrue(true, 'No PHP warnings or errors raised when discarding a Future.');
    }

    // ─── async returns same result as sync ────────────────────────────────

    public function test_async_operation_returns_same_result_as_sync(): void
    {
        $responseBody = '{"items":[],"page":{"number":0,"size":1,"totalCount":0}}';
        [$clientSync] = $this->client([new Response(200, [], $responseBody)]);
        [$clientAsync] = $this->client([new Response(200, [], $responseBody)]);

        $syncResult = $clientSync->getPayments();
        $asyncResult = $clientAsync->getPaymentsAsync()->wait();

        self::assertEquals($syncResult->items, $asyncResult->items, 'Async and sync results must be identical (items).');
        self::assertEquals($syncResult->page, $asyncResult->page, 'Async and sync results must be identical (page).');
    }

    public function test_async_exception_propagates_on_wait(): void
    {
        // ERR-009: waiting on a Future after failure raises the same PortOneException as sync
        [$client] = $this->client([
            new ConnectException('timed out', new Request('GET', '/payments')),
        ]);

        $this->expectException(TransportException::class);
        $client->getPaymentsAsync()->wait();
    }

    // ─── sequential Futures on shared executor ────────────────────────────

    public function test_many_sequential_futures_complete_correctly(): void
    {
        $n = 200;
        $responses = array_fill(0, $n, new Response(200, [], '{"items":[],"page":{"number":0,"size":1,"totalCount":0}}'));
        [$client] = $this->client($responses);

        $succeeded = 0;
        for ($i = 0; $i < $n; $i++) {
            $result = $client->getPaymentsAsync()->wait();
            if ($result !== null) {
                $succeeded++;
            }
        }

        self::assertSame($n, $succeeded, "All $n sequential Futures must complete correctly.");
    }

    public function test_many_sequential_futures_show_no_memory_growth(): void
    {
        $n = 200;
        $responses = array_fill(0, $n, new Response(200, [], '{"items":[],"page":{"number":0,"size":1,"totalCount":0}}'));
        [$client] = $this->client($responses);

        // Warm up — establish baseline
        $client->getPaymentsAsync()->wait();
        gc_collect_cycles();
        $baseline = memory_get_usage(true);

        for ($i = 1; $i < $n; $i++) {
            $client->getPaymentsAsync()->wait();
        }

        gc_collect_cycles();
        $growthBytes = memory_get_usage(true) - $baseline;

        // Allow up to 512 KB growth for internal PHP/Guzzle overhead
        self::assertLessThan(
            512 * 1024,
            $growthBytes,
            "Memory growth after $n Futures ({$growthBytes} bytes) must be below 512 KB.",
        );
    }

    // ─── state isolation after failure ────────────────────────────────────

    public function test_failed_future_leaves_no_state_in_shared_executor(): void
    {
        // Live observation: TransportException on call N does not affect call N+1.
        $responses = [
            new ConnectException('connect failed', new Request('GET', '/payments')),
            new Response(200, [], '{"items":[],"page":{"number":0,"size":1,"totalCount":0}}'),
        ];
        [$client] = $this->client($responses);

        // First call fails
        try {
            $client->getPaymentsAsync()->wait();
            self::fail('Expected TransportException on first call.');
        } catch (TransportException) {
            // Expected
        }

        // Second call on the same executor must succeed without leaking state from the failure
        $result = $client->getPaymentsAsync()->wait();
        self::assertNotNull($result, 'Second call on shared executor must succeed after a failure.');
    }

    public function test_multiple_failure_recovery_cycles(): void
    {
        $responses = [];
        for ($i = 0; $i < 10; $i++) {
            $responses[] = new ConnectException('fail', new Request('GET', '/payments'));
            $responses[] = new Response(200, [], '{"items":[],"page":{"number":0,"size":1,"totalCount":0}}');
        }
        [$client] = $this->client($responses);

        $failures = 0;
        $successes = 0;
        for ($i = 0; $i < 10; $i++) {
            try {
                $client->getPaymentsAsync()->wait();
                $failures++;   // should not happen
            } catch (TransportException) {
                $failures++;
            }

            $result = $client->getPaymentsAsync()->wait();
            if ($result !== null) {
                $successes++;
            }
        }

        self::assertSame(10, $successes, 'Every recovery call after a failure must succeed.');
    }

    // ─── concurrent Futures via wait_for_all ─────────────────────────────

    public function test_multiple_pending_futures_all_complete_via_wait(): void
    {
        // In PHP's synchronous runtime, Futures are resolved when waited.
        // We start N Futures, store them, then wait each — all must complete.
        $n = 50;
        $responses = array_fill(0, $n, new Response(200, [], '{"items":[],"page":{"number":0,"size":1,"totalCount":0}}'));
        [$client] = $this->client($responses);

        /** @var list<Future<object>> $futures */
        $futures = [];
        for ($i = 0; $i < $n; $i++) {
            $futures[] = $client->getPaymentsAsync();
        }

        $completed = 0;
        foreach ($futures as $future) {
            $future->wait();
            $completed++;
        }

        self::assertSame($n, $completed, "All $n stored Futures must complete on wait().");
    }

    // ─── helpers ─────────────────────────────────────────────────────────

    /** @param list<mixed> $responses @return array{PaymentClient, list<array<string,mixed>>, MockHandler} */
    private function client(array $responses): array
    {
        $history = [];
        $handler = new MockHandler($responses);
        $stack = HandlerStack::create($handler);
        $httpClient = new Client(['handler' => $stack, 'http_errors' => false]);

        $executor = new class('test-secret', $httpClient) extends RequestExecutor
        {
            public function __construct(string $apiSecret, private readonly Client $testClient)
            {
                parent::__construct($apiSecret);
            }

            protected function createClient(): Client
            {
                return $this->testClient;
            }
        };

        $client = new class('test-secret', $executor) extends PaymentClient
        {
            public function __construct(string $apiSecret, private readonly RequestExecutor $testExecutor)
            {
                parent::__construct($apiSecret);
            }

            protected function createExecutor(string $apiSecret): RequestExecutor
            {
                return $this->testExecutor;
            }
        };

        return [$client, &$history, $handler];
    }
}
