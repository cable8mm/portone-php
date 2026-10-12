<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Client\ReconciliationClient;
use Cable8mm\PortonePhp\Exception\ForbiddenException;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\Model\GetPaymentReconciliationSettlementVatReportResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class ReconciliationClientTest extends TestCase
{
    public function test_settlement_report_sends_the_query_shape_and_decodes_the_typed_response(): void
    {
        $history = [];
        $client = $this->client(new MockHandler([
            new Response(200, [], '{"items":[],"summary":{}}'),
        ]), $history);

        $result = $client->getPaymentReconciliationSettlementVatReport(
            ['from' => '2026-01-01', 'until' => '2026-01-31'],
            ['storeIds' => ['store-id']],
        );

        self::assertInstanceOf(GetPaymentReconciliationSettlementVatReportResponse::class, $result);
        self::assertSame([], $result->items);
        self::assertSame('/payment-reconciliations/settlements/vat-report', $history[0]['request']->getUri()->getPath());
        self::assertSame(
            '{"dateRange":{"from":"2026-01-01","until":"2026-01-31"},"filter":{"storeIds":["store-id"]}}',
            rawurldecode((string) explode('=', (string) $history[0]['request']->getUri()->getQuery(), 2)[1]),
        );
    }

    public function test_transaction_report_async_returns_a_future_with_the_typed_result(): void
    {
        $client = $this->client(new MockHandler([
            new Response(200, [], '{"items":[],"summary":{}}'),
        ]));

        $future = $client->getPaymentReconciliationTransactionVatReportAsync(['from' => '2026-01-01', 'until' => '2026-01-31']);

        self::assertInstanceOf(Future::class, $future);
        self::assertSame([], $future->wait()->items);
    }

    public function test_forbidden_error_is_classified_as_a_port_one_failure(): void
    {
        $client = $this->client(new MockHandler([
            new Response(403, [], '{"type":"FORBIDDEN","message":"forbidden"}'),
        ]));

        $this->expectException(ForbiddenException::class);
        $client->getPaymentReconciliationSettlementVatReport(['from' => '2026-01-01', 'until' => '2026-01-31']);
    }

    /** @param array<int,array<string,mixed>> $history */
    private function client(MockHandler $handler, array &$history = []): ReconciliationClient
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

        return new ReconciliationClient('test-secret', $executor);
    }
}
