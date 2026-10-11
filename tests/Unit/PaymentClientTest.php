<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Exception\InvalidRequestException;
use Cable8mm\PortonePhp\Exception\TransportException;
use Cable8mm\PortonePhp\Exception\UnknownException;
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
use Psr\Http\Message\RequestInterface;

final class PaymentClientTest extends TestCase
{
    public function test_synchronous_operation_builds_one_authenticated_request_and_decodes_result(): void
    {
        $history = [];
        $client = $this->paymentClient(new MockHandler([
            new Response(200, [], '{"items":[],"page":{"number":0,"size":1,"totalCount":0}}'),
        ]), $history);

        $result = $client->getPayments(['number' => 0, 'size' => 1]);

        self::assertSame([], $result->items);
        self::assertSame(0, $result->page['number']);
        self::assertCount(1, $history);
        self::assertSame('PortOne test-secret', $history[0]['request']->getHeaderLine('Authorization'));
        self::assertSame(
            '{"page":{"number":0,"size":1}}',
            (string) $history[0]['request']->getUri()->getQuery() === ''
                ? ''
                : rawurldecode((string) explode('=', (string) $history[0]['request']->getUri()->getQuery(), 2)[1]),
        );
        self::assertSame(10, $history[0]['options']['connect_timeout']);
        self::assertSame(30, $history[0]['options']['timeout']);
    }

    public function test_asynchronous_operation_returns_future_and_uses_one_request(): void
    {
        $history = [];
        $client = $this->paymentClient(new MockHandler([
            new Response(200, [], '{"items":[],"page":{"number":0,"size":1,"totalCount":0}}'),
        ]), $history);

        $future = $client->getPaymentsAsync(['number' => 0, 'size' => 1]);

        self::assertInstanceOf(Future::class, $future);
        $result = $future->wait();

        self::assertSame([], $result->items);
        self::assertCount(1, $history);
    }

    public function test_defined_and_unknown_errors_become_port_one_failures(): void
    {
        $defined = $this->paymentClient(new MockHandler([
            new Response(400, [], '{"type":"INVALID_REQUEST","message":"bad request"}'),
        ]));
        try {
            $defined->getPayments();
            self::fail('Expected InvalidRequestException.');
        } catch (InvalidRequestException $exception) {
            self::assertSame(400, $exception->status);
        }

        $unknown = $this->paymentClient(new MockHandler([
            new Response(418, [], 'not-json'),
        ]));
        try {
            $unknown->getPayments();
            self::fail('Expected UnknownException.');
        } catch (UnknownException $exception) {
            self::assertSame('getPayments', $exception->operation);
        }
    }

    public function test_undecodable_success_becomes_unrecognized_response_exception(): void
    {
        $client = $this->paymentClient(new MockHandler([
            new Response(200, [], 'not-json'),
        ]));

        $this->expectException(UnrecognizedResponseException::class);
        try {
            $client->getPayments();
        } catch (UnrecognizedResponseException $exception) {
            self::assertSame(200, $exception->status);
            self::assertSame('not-json', $exception->responseBody);
            throw $exception;
        }
    }

    public function test_async_wait_propagates_the_same_decode_failure(): void
    {
        $client = $this->paymentClient(new MockHandler([
            new Response(200, [], 'not-json'),
        ]));

        $this->expectException(UnrecognizedResponseException::class);
        $client->getPaymentsAsync()->wait();
    }

    public function test_transport_failure_becomes_port_one_transport_exception(): void
    {
        $client = $this->paymentClient(new MockHandler([
            new ConnectException('connection failed', new Request('GET', '/payments')),
        ]));

        $this->expectException(TransportException::class);
        $client->getPayments();
    }

    public function test_a_failed_call_does_not_affect_the_next_call(): void
    {
        $client = $this->paymentClient(new MockHandler([
            new Response(200, [], 'not-json'),
            new Response(200, [], '{"items":[],"page":{"number":0,"size":1,"totalCount":0}}'),
        ]));

        try {
            $client->getPayments();
        } catch (UnrecognizedResponseException) {
        }

        $result = $client->getPayments();

        self::assertSame([], $result->items);
    }

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
