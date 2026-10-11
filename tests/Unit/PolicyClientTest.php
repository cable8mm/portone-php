<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Future;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\PolicyClient;
use Cable8mm\PortonePhp\Response\GetPlatformContractsResponse;
use Cable8mm\PortonePhp\Response\GetPlatformDiscountSharePoliciesResponse;
use Cable8mm\PortonePhp\Response\UpdatePlatformContractResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class PolicyClientTest extends TestCase
{
    public function test_contract_list_uses_the_query_request_body_shape(): void
    {
        $history = [];
        $client = $this->client(new MockHandler([
            new Response(200, [], '{"items":[],"page":{}}'),
        ]), $history);

        $result = $client->getPlatformContracts(true, ['number' => 0], ['status' => ['ACTIVE']]);

        self::assertInstanceOf(GetPlatformContractsResponse::class, $result);
        self::assertStringStartsWith('test=1&requestBody=', (string) $history[0]['request']->getUri()->getQuery());
        self::assertStringContainsString('requestBody=', (string) $history[0]['request']->getUri());
    }

    public function test_update_contract_uses_query_and_json_body(): void
    {
        $history = [];
        $client = $this->client(new MockHandler([
            new Response(200, [], '{"contract":{"id":"contract-id"}}'),
        ]), $history);

        $result = $client->updatePlatformContract('contract-id', true, 'Updated contract');

        self::assertInstanceOf(UpdatePlatformContractResponse::class, $result);
        self::assertSame('test=1', (string) $history[0]['request']->getUri()->getQuery());
        self::assertSame('{"name":"Updated contract"}', (string) $history[0]['request']->getBody());
    }

    public function test_discount_share_policy_async_returns_a_future(): void
    {
        $client = $this->client(new MockHandler([
            new Response(200, [], '{"items":[],"page":{}}'),
        ]));

        $future = $client->getPlatformDiscountSharePoliciesAsync();

        self::assertInstanceOf(Future::class, $future);
        self::assertInstanceOf(GetPlatformDiscountSharePoliciesResponse::class, $future->wait());
    }

    /** @param array<int,array<string,mixed>> $history */
    private function client(MockHandler $handler, array &$history = []): PolicyClient
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

        return new PolicyClient('test-secret', $executor);
    }
}
