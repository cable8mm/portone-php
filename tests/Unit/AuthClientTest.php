<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\AuthClient;
use Cable8mm\PortonePhp\Exception\UnauthorizedException;
use Cable8mm\PortonePhp\Future;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\Response\LoginViaApiSecretResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class AuthClientTest extends TestCase
{
    public function test_login_sends_the_observed_request_shape_and_decodes_the_typed_response(): void
    {
        $history = [];
        $client = $this->client(new MockHandler([
            new Response(200, [], '{"accessToken":"access","refreshToken":"refresh"}'),
        ]), $history);

        $result = $client->loginViaApiSecret('operation-secret');

        self::assertInstanceOf(LoginViaApiSecretResponse::class, $result);
        self::assertSame('access', $result->data['accessToken']);
        self::assertCount(1, $history);
        self::assertSame('POST', $history[0]['request']->getMethod());
        self::assertSame('/login/api-secret', $history[0]['request']->getUri()->getPath());
        self::assertSame('{"apiSecret":"operation-secret"}', (string) $history[0]['request']->getBody());
    }

    public function test_refresh_token_async_returns_a_future_with_the_typed_result(): void
    {
        $client = $this->client(new MockHandler([
            new Response(200, [], '{"accessToken":"access","refreshToken":"refresh"}'),
        ]));

        $future = $client->refreshTokenAsync('refresh');

        self::assertInstanceOf(Future::class, $future);
        self::assertSame('access', $future->wait()->data['accessToken']);
    }

    public function test_refresh_token_maps_the_observed_unauthorized_error(): void
    {
        $client = $this->client(new MockHandler([
            new Response(401, [], '{"type":"UNAUTHORIZED","message":"invalid token"}'),
        ]));

        $this->expectException(UnauthorizedException::class);
        $client->refreshToken('invalid');
    }

    /** @param array<int,array<string,mixed>> $history */
    private function client(MockHandler $handler, array &$history = []): AuthClient
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

        return new AuthClient('test-secret', $executor);
    }
}
