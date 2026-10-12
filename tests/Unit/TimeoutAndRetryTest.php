<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Client\PaymentClient;
use Cable8mm\PortonePhp\Exception\TransportException;
use Cable8mm\PortonePhp\Exception\UnknownException;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * Unit tests for T-053: Duplicate request and timeout recovery behavior.
 *
 * Verifies (against a local mock, no live network):
 *  - SDK makes exactly one HTTP request on transport failure (no retry).
 *  - SDK makes exactly one HTTP request on 5xx response (no retry).
 *  - SDK makes exactly one HTTP request on ConnectException (no retry).
 *  - TransportException is raised on ConnectException (AC-014 / ERR-006).
 *  - ALREADY_PAID error type is preserved in UnknownException (AC-018 / ERR-003).
 *  - Async wait propagates TransportException (ERR-009).
 */
final class TimeoutAndRetryTest extends TestCase
{
    // ─── no-retry: transport failure ────────────────────────────────────────

    public function test_connect_exception_produces_transport_exception_with_exactly_one_request(): void
    {
        $history = [];
        $client = $this->paymentClient(new MockHandler([
            new ConnectException('connection timed out', new Request('POST', '/payments/pay-t/instant')),
        ]), $history);

        try {
            $client->getPayments();
            self::fail('Expected TransportException.');
        } catch (TransportException) {
            // correct
        }

        self::assertCount(1, $history, 'SDK must not retry on transport failure.');
    }

    public function test_async_transport_failure_propagates_as_transport_exception_with_one_request(): void
    {
        $history = [];
        $client = $this->paymentClient(new MockHandler([
            new ConnectException('connection timed out', new Request('POST', '/payments/pay-t/instant')),
        ]), $history);

        try {
            $client->getPaymentsAsync()->wait();
            self::fail('Expected TransportException.');
        } catch (TransportException) {
            // correct
        }

        self::assertCount(1, $history, 'SDK must not retry on async transport failure.');
    }

    // ─── no-retry: 5xx ──────────────────────────────────────────────────────

    public function test_5xx_response_produces_unknown_exception_with_exactly_one_request(): void
    {
        $history = [];
        $client = $this->paymentClient(new MockHandler([
            new Response(500, [], '{"type":"INTERNAL","message":"server error"}'),
        ]), $history);

        try {
            $client->getPayments();
            self::fail('Expected UnknownException.');
        } catch (UnknownException) {
            // correct
        }

        self::assertCount(1, $history, 'SDK must not retry on 5xx response.');
    }

    public function test_async_5xx_produces_unknown_exception_with_one_request(): void
    {
        $history = [];
        $client = $this->paymentClient(new MockHandler([
            new Response(500, [], '{"type":"INTERNAL","message":"server error"}'),
        ]), $history);

        try {
            $client->getPaymentsAsync()->wait();
            self::fail('Expected UnknownException.');
        } catch (UnknownException) {
            // correct
        }

        self::assertCount(1, $history, 'SDK must not retry on async 5xx response.');
    }

    // ─── no-retry: 502 (gateway error) ──────────────────────────────────────

    public function test_502_response_produces_unknown_exception_with_exactly_one_request(): void
    {
        $history = [];
        $client = $this->paymentClient(new MockHandler([
            new Response(502, [], ''),
        ]), $history);

        try {
            $client->getPayments();
            self::fail('Expected UnknownException.');
        } catch (UnknownException) {
            // correct
        }

        self::assertCount(1, $history, 'SDK must not retry on 502 response.');
    }

    // ─── duplicate payment error type ───────────────────────────────────────

    public function test_already_paid_error_type_is_preserved_in_unknown_exception(): void
    {
        $body = '{"type":"ALREADY_PAID","message":"이미 결제된 건입니다."}';
        $client = $this->paymentClient(new MockHandler([
            new Response(409, [], $body),
        ]));

        try {
            $client->payInstantly(
                paymentId: 'dup-pay-001',
                channelKey: 'channel-key',
                channelGroupId: null,
                method: ['card' => ['credential' => ['number' => '4111111111111111', 'expiryYear' => '26', 'expiryMonth' => '01']]],
                orderName: 'duplicate test',
                isCulturalExpense: false,
                isEscrow: false,
                customer: null,
                customData: null,
                amount: ['total' => 1000, 'taxFree' => 0],
                currency: 'KRW',
            );
            self::fail('Expected UnknownException.');
        } catch (UnknownException $exception) {
            self::assertSame('ALREADY_PAID', $exception->errorType);
            self::assertSame(409, $exception->status);
            self::assertSame($body, $exception->responseBody);
            self::assertSame('payInstantly', $exception->operation);
        }
    }

    // ─── timeouts applied ───────────────────────────────────────────────────

    public function test_connect_timeout_and_total_timeout_are_applied_to_every_request(): void
    {
        $history = [];
        $client = $this->paymentClient(new MockHandler([
            new Response(200, [], '{"items":[],"page":{"number":0,"size":1,"totalCount":0}}'),
        ]), $history);

        $client->getPayments();

        self::assertCount(1, $history);
        self::assertSame(10, $history[0]['options']['connect_timeout']);
        self::assertSame(30, $history[0]['options']['timeout']);
    }

    // ─── helpers ────────────────────────────────────────────────────────────

    /** @param list<array{request:RequestInterface, options:array<string,mixed>}> $history */
    private function paymentClient(MockHandler $handler, array &$history = []): PaymentClient
    {
        $stack = HandlerStack::create($handler);
        $stack->push(Middleware::history($history));
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

        return new class('test-secret', $executor) extends PaymentClient
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
    }
}
