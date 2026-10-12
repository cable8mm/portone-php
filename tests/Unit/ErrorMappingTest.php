<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Client\PaymentClient;
use Cable8mm\PortonePhp\Exception\ForbiddenException;
use Cable8mm\PortonePhp\Exception\PlatformNotEnabledException;
use Cable8mm\PortonePhp\Exception\UnauthorizedException;
use Cable8mm\PortonePhp\Exception\UnknownException;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class ErrorMappingTest extends TestCase
{
    public function test_defined_error_types_preserve_type_status_message_and_body(): void
    {
        foreach ([
            ['FORBIDDEN', ForbiddenException::class],
            ['PLATFORM_NOT_ENABLED', PlatformNotEnabledException::class],
            ['UNAUTHORIZED', UnauthorizedException::class],
        ] as [$type, $exceptionClass]) {
            $body = json_encode(['type' => $type, 'message' => 'controlled failure'], JSON_THROW_ON_ERROR);
            $client = $this->client(new MockHandler([new Response(403, [], $body)]));

            try {
                $client->getPayments();
                self::fail('Expected '.$exceptionClass.'.');
            } catch (\Throwable $exception) {
                self::assertInstanceOf($exceptionClass, $exception);
                self::assertSame($type, $exception->errorType);
                self::assertSame(403, $exception->status);
                self::assertSame($body, $exception->responseBody);
            }
        }
    }

    public function test_unknown_error_type_is_preserved_on_sync_and_async_paths(): void
    {
        $body = '{"type":"FUTURE_ERROR","message":"future"}';
        $client = $this->client(new MockHandler([new Response(499, [], $body), new Response(499, [], $body)]));

        try {
            $client->getPayments();
            self::fail('Expected UnknownException.');
        } catch (UnknownException $exception) {
            self::assertSame('FUTURE_ERROR', $exception->errorType);
            self::assertSame(499, $exception->status);
            self::assertSame($body, $exception->responseBody);
        }

        try {
            $client->getPaymentsAsync()->wait();
            self::fail('Expected UnknownException.');
        } catch (UnknownException $exception) {
            self::assertSame('FUTURE_ERROR', $exception->errorType);
            self::assertSame(499, $exception->status);
        }
    }

    private function client(MockHandler $handler): PaymentClient
    {
        $httpClient = new Client(['handler' => HandlerStack::create($handler), 'http_errors' => false]);
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
