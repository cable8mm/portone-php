<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Future;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\PartnerClient;
use Cable8mm\PortonePhp\PartnerSettlementClient;
use Cable8mm\PortonePhp\Response\GetPlatformPartnerSettlementsResponse;
use Cable8mm\PortonePhp\Response\UpdatePlatformPartnerResponse;
use Cable8mm\PortonePhp\TransferClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class PlatformPartnerTransferClientsTest extends TestCase
{
    public function test_partner_settlement_list_uses_the_query_request_body_shape(): void
    {
        $history = [];
        $client = $this->client(PartnerSettlementClient::class, new MockHandler([
            new Response(200, [], '{"items":[]}'),
        ]), $history);

        $result = $client->getPlatformPartnerSettlements(false, ['number' => 0], ['status' => ['PENDING']], false);

        self::assertInstanceOf(GetPlatformPartnerSettlementsResponse::class, $result);
        self::assertStringContainsString('requestBody=', (string) $history[0]['request']->getUri());
    }

    public function test_partner_update_uses_query_and_json_body(): void
    {
        $history = [];
        $client = $this->client(PartnerClient::class, new MockHandler([
            new Response(200, [], '{"partner":{"id":"partner-id"}}'),
        ]), $history);

        $result = $client->updatePlatformPartner('partner-id', true, 'Updated partner');

        self::assertInstanceOf(UpdatePlatformPartnerResponse::class, $result);
        self::assertSame('test=1', (string) $history[0]['request']->getUri()->getQuery());
        self::assertSame('{"name":"Updated partner"}', (string) $history[0]['request']->getBody());
    }

    public function test_transfer_sheet_returns_a_string_and_async_wait_preserves_it(): void
    {
        $client = $this->client(TransferClient::class, new MockHandler([
            new Response(200, ['Content-Type' => 'text/csv'], "id,name\n1,Test\n"),
            new Response(200, ['Content-Type' => 'text/csv'], "id,name\n1,Test\n"),
        ]));

        self::assertSame("id,name\n1,Test\n", $client->downloadPlatformTransferSheet());
        $future = $client->downloadPlatformTransferSheetAsync();
        self::assertInstanceOf(Future::class, $future);
        self::assertSame("id,name\n1,Test\n", $future->wait());
    }

    /** @param array<int,array<string,mixed>> $history */
    private function client(string $class, MockHandler $handler, array &$history = []): object
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

        return new $class('test-secret', $executor);
    }
}
