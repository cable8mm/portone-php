<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\BulkAccountTransferClient;
use Cable8mm\PortonePhp\BulkPayoutClient;
use Cable8mm\PortonePhp\Future;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\PayoutClient;
use Cable8mm\PortonePhp\Response\CompletePlatformPayoutByPartnerSettlementIdsResponse;
use Cable8mm\PortonePhp\Response\GetPlatformBulkAccountTransfersResponse;
use Cable8mm\PortonePhp\Response\GetPlatformBulkPayoutsResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class PlatformBulkPayoutClientsTest extends TestCase
{
    public function test_bulk_account_transfers_use_the_jvm_query_request_body_shape(): void
    {
        $history = [];
        $client = $this->client(BulkAccountTransferClient::class, new MockHandler([
            new Response(200, [], '{"counts":{},"items":[],"page":{}}'),
        ]), $history);

        $result = $client->getPlatformBulkAccountTransfers(true, false, ['number' => 0], ['status' => ['PENDING']]);

        self::assertInstanceOf(GetPlatformBulkAccountTransfersResponse::class, $result);
        self::assertStringContainsString('test=1', (string) $history[0]['request']->getUri());
        self::assertStringContainsString('requestBody=', (string) $history[0]['request']->getUri());
    }

    public function test_bulk_payout_async_returns_a_typed_future_result(): void
    {
        $client = $this->client(BulkPayoutClient::class, new MockHandler([
            new Response(200, [], '{"counts":{},"items":[],"page":{}}'),
        ]));

        $future = $client->getPlatformBulkPayoutsAsync();

        self::assertInstanceOf(Future::class, $future);
        self::assertInstanceOf(GetPlatformBulkPayoutsResponse::class, $future->wait());
    }

    public function test_payout_completion_uses_query_and_json_body(): void
    {
        $history = [];
        $client = $this->client(PayoutClient::class, new MockHandler([
            new Response(200, [], '{"bulkPayoutId":"payout-id","payoutCount":0,"partnerSettlementCount":0}'),
        ]), $history);

        $result = $client->completePlatformPayoutByPartnerSettlementIds(
            true,
            'bulk-payout-id',
            'January payout',
            ['settlement-id'],
            '2026-01-31T00:00:00Z',
            false,
        );

        self::assertInstanceOf(CompletePlatformPayoutByPartnerSettlementIdsResponse::class, $result);
        self::assertSame('{"bulkPayoutId":"bulk-payout-id","name":"January payout","partnerSettlementIds":["settlement-id"],"completedAt":"2026-01-31T00:00:00Z","isForTest":false}', (string) $history[0]['request']->getBody());
        self::assertSame('/platform/partner-settlements/complete-payout', $history[0]['request']->getUri()->getPath());
        self::assertSame('test=1', (string) $history[0]['request']->getUri()->getQuery());
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
