<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Client\TaxInvoiceClient;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\Model\CreateB2bFileUploadUrlPayload;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class TaxInvoiceClientTest extends TestCase
{
    public function test_file_upload_url_uses_query_and_json_body(): void
    {
        $history = [];
        $client = $this->client(new MockHandler([
            new Response(200, [], '{"fileId":"file-id","url":"https://example.test/upload"}'),
        ]), $history);

        $result = $client->createB2bFileUploadUrl(true, 'invoice.csv');

        self::assertInstanceOf(CreateB2bFileUploadUrlPayload::class, $result);
        self::assertSame('test=1', (string) $history[0]['request']->getUri()->getQuery());
        self::assertSame('{"fileName":"invoice.csv"}', (string) $history[0]['request']->getBody());
    }

    public function test_tax_invoice_list_uses_the_query_request_body_shape(): void
    {
        $history = [];
        $client = $this->client(new MockHandler([
            new Response(200, [], '{"items":[],"page":{}}'),
        ]), $history);

        $result = $client->getB2bTaxInvoices(true, 0, 1, [], []);

        self::assertSame([], $result->items);
        self::assertStringContainsString('requestBody=', (string) $history[0]['request']->getUri());
    }

    public function test_csv_and_unit_async_operations_preserve_their_success_results(): void
    {
        $client = $this->client(new MockHandler([
            new Response(200, ['Content-Type' => 'text/csv'], "key\nvalue\n"),
            new Response(204),
        ]));

        self::assertSame("key\nvalue\n", $client->downloadB2bTaxInvoicesSheetAsync()->wait());
        $client->attachB2bTaxInvoiceFile('tax-invoice-key', null, null, null, 'file-id');
        self::assertTrue(true);
    }

    /** @param array<int,array<string,mixed>> $history */
    private function client(MockHandler $handler, array &$history = []): TaxInvoiceClient
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

        return new TaxInvoiceClient('test-secret', $executor);
    }
}
