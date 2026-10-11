<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Exception\InvalidRequestException;
use Cable8mm\PortonePhp\Exception\TransportException;
use Cable8mm\PortonePhp\Exception\UnrecognizedResponseException;
use Cable8mm\PortonePhp\Future;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\PaymentClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class AsyncParityTest extends TestCase
{
    public function test_sync_and_async_success_use_the_same_request_and_result(): void
    {
        $body = '{"items":[],"page":{"number":0,"size":1,"totalCount":0}}';
        $syncHistory = [];
        $asyncHistory = [];
        $sync = $this->client(new MockHandler([new Response(200, [], $body)]), $syncHistory);
        $async = $this->client(new MockHandler([new Response(200, [], $body)]), $asyncHistory);

        $syncResult = $sync->getPayments(['number' => 0, 'size' => 1]);
        $future = $async->getPaymentsAsync(['number' => 0, 'size' => 1]);

        self::assertInstanceOf(Future::class, $future);
        $asyncResult = $future->wait();
        self::assertSame($syncResult->items, $asyncResult->items);
        self::assertSame($syncResult->page, $asyncResult->page);
        self::assertSame(
            (string) $syncHistory[0]['request']->getUri(),
            (string) $asyncHistory[0]['request']->getUri(),
        );
        self::assertSame(
            $syncHistory[0]['request']->getHeaderLine('Authorization'),
            $asyncHistory[0]['request']->getHeaderLine('Authorization'),
        );
        self::assertCount(1, $syncHistory);
        self::assertCount(1, $asyncHistory);
    }

    public function test_sync_and_async_api_failures_are_equivalent(): void
    {
        $body = '{"type":"INVALID_REQUEST","message":"bad request"}';
        $sync = $this->client(new MockHandler([new Response(400, [], $body)]));
        $async = $this->client(new MockHandler([new Response(400, [], $body)]));

        $syncException = $this->capture(static fn (): mixed => $sync->getPayments());
        $asyncException = $this->capture(static fn (): mixed => $async->getPaymentsAsync()->wait());

        self::assertInstanceOf(InvalidRequestException::class, $syncException);
        self::assertInstanceOf(InvalidRequestException::class, $asyncException);
        self::assertSame($syncException::class, $asyncException::class);
        self::assertSame($syncException->status, $asyncException->status);
        self::assertSame($syncException->errorType, $asyncException->errorType);
        self::assertSame($syncException->responseBody, $asyncException->responseBody);
    }

    public function test_sync_and_async_decode_failures_are_equivalent(): void
    {
        $sync = $this->client(new MockHandler([new Response(200, [], 'not-json')]));
        $async = $this->client(new MockHandler([new Response(200, [], 'not-json')]));

        $syncException = $this->capture(static fn (): mixed => $sync->getPayments());
        $asyncException = $this->capture(static fn (): mixed => $async->getPaymentsAsync()->wait());

        self::assertInstanceOf(UnrecognizedResponseException::class, $syncException);
        self::assertInstanceOf(UnrecognizedResponseException::class, $asyncException);
        self::assertSame($syncException::class, $asyncException::class);
        self::assertSame($syncException->status, $asyncException->status);
        self::assertSame($syncException->responseBody, $asyncException->responseBody);
    }

    public function test_sync_and_async_transport_failures_are_equivalent(): void
    {
        $sync = $this->client(new MockHandler([
            new ConnectException('connection failed', new Request('GET', '/payments')),
        ]));
        $async = $this->client(new MockHandler([
            new ConnectException('connection failed', new Request('GET', '/payments')),
        ]));

        $syncException = $this->capture(static fn (): mixed => $sync->getPayments());
        $asyncException = $this->capture(static fn (): mixed => $async->getPaymentsAsync()->wait());

        self::assertInstanceOf(TransportException::class, $syncException);
        self::assertInstanceOf(TransportException::class, $asyncException);
        self::assertSame($syncException::class, $asyncException::class);
        self::assertSame($syncException->getMessage(), $asyncException->getMessage());
    }

    /** @param Closure(): mixed $operation */
    private function capture(\Closure $operation): \Throwable
    {
        try {
            $operation();
        } catch (\Throwable $exception) {
            return $exception;
        }

        self::fail('Expected the operation to fail.');
    }

    /** @param array<int,array<string,mixed>> $history */
    private function client(MockHandler $handler, array &$history = []): PaymentClient
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
