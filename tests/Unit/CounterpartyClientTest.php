<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\CounterpartyClient;
use Cable8mm\PortonePhp\Future;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\Response\CreateB2bCounterpartyResponse;
use Cable8mm\PortonePhp\Response\GetB2bCounterpartiesResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class CounterpartyClientTest extends TestCase
{
    public function test_create_counterparty_uses_query_and_json_body(): void
    {
        $history = [];
        $client = $this->client(new MockHandler([
            new Response(200, [], '{"counterparty":{"id":"counterparty-id"}}'),
        ]), $history);

        $result = $client->createB2bCounterparty(true, 'counterparty-id', ['name' => 'Test'], ['verify' => false]);

        self::assertInstanceOf(CreateB2bCounterpartyResponse::class, $result);
        self::assertSame('test=1', (string) $history[0]['request']->getUri()->getQuery());
        self::assertSame('{"counterpartyId":"counterparty-id","counterparty":{"name":"Test"},"options":{"verify":false}}', (string) $history[0]['request']->getBody());
    }

    public function test_counterparty_list_uses_the_query_request_body_shape_and_async_result(): void
    {
        $history = [];
        $client = $this->client(new MockHandler([
            new Response(200, [], '{"items":[],"page":{}}'),
        ]), $history);

        $future = $client->getB2bCounterpartiesAsync(true, ['number' => 0], ['status' => ['ACTIVE']]);

        self::assertInstanceOf(Future::class, $future);
        self::assertInstanceOf(GetB2bCounterpartiesResponse::class, $future->wait());
        self::assertStringContainsString('requestBody=', (string) $history[0]['request']->getUri());
    }

    /** @param array<int,array<string,mixed>> $history */
    private function client(MockHandler $handler, array &$history = []): CounterpartyClient
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

        return new CounterpartyClient('test-secret', $executor);
    }
}
