<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\AccountClient;
use Cable8mm\PortonePhp\AccountTransferClient;
use Cable8mm\PortonePhp\CompanyClient;
use Cable8mm\PortonePhp\Exception\PlatformNotEnabledException;
use Cable8mm\PortonePhp\Future;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\PlatformClient;
use Cable8mm\PortonePhp\Response\GetB2bBusinessInfosResponse;
use Cable8mm\PortonePhp\Response\GetPlatformAccountTransfersResponse;
use Cable8mm\PortonePhp\Response\GetPlatformCompanyStatePayload;
use Cable8mm\PortonePhp\Response\PlatformSetting;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class PlatformCoreClientsTest extends TestCase
{
    public function test_company_operation_sends_query_and_json_body(): void
    {
        $history = [];
        $client = $this->client(CompanyClient::class, new MockHandler([
            new Response(200, [], '{"items":[]}'),
        ]), $history);

        $result = $client->getB2bBusinessInfos(true, ['1234567890']);

        self::assertInstanceOf(GetB2bBusinessInfosResponse::class, $result);
        self::assertSame('test=1', (string) $history[0]['request']->getUri()->getQuery());
        self::assertSame('{"brnList":["1234567890"]}', (string) $history[0]['request']->getBody());
    }

    public function test_account_and_company_get_operations_decode_typed_results(): void
    {
        $account = $this->client(AccountClient::class, new MockHandler([
            new Response(200, [], '{"holderName":"Test"}'),
        ]));
        self::assertSame('Test', $account->getPlatformAccountHolder('SHINHAN', '1234567890')->data['holderName']);

        $company = $this->client(CompanyClient::class, new MockHandler([
            new Response(200, [], '{"status":"ACTIVE"}'),
        ]));
        self::assertInstanceOf(
            GetPlatformCompanyStatePayload::class,
            $company->getPlatformCompanyState('1234567890'),
        );
    }

    public function test_account_transfer_request_body_and_async_platform_result(): void
    {
        $history = [];
        $transfers = $this->client(AccountTransferClient::class, new MockHandler([
            new Response(200, [], '{"items":[]}'),
        ]), $history);
        $result = $transfers->getPlatformAccountTransfers(true, false, ['number' => 0], ['status' => ['PENDING']]);

        self::assertInstanceOf(GetPlatformAccountTransfersResponse::class, $result);
        self::assertStringContainsString('test=1', (string) $history[0]['request']->getUri());
        self::assertStringContainsString('requestBody=', (string) $history[0]['request']->getUri());

        $platform = $this->client(PlatformClient::class, new MockHandler([
            new Response(200, [], '{"defaultWithdrawalMemo":"memo"}'),
        ]));
        $future = $platform->getPlatformSettingAsync();

        self::assertInstanceOf(Future::class, $future);
        self::assertInstanceOf(PlatformSetting::class, $future->wait());
    }

    public function test_platform_not_enabled_error_is_classified(): void
    {
        $client = $this->client(PlatformClient::class, new MockHandler([
            new Response(403, [], '{"type":"PLATFORM_NOT_ENABLED","message":"disabled"}'),
        ]));

        $this->expectException(PlatformNotEnabledException::class);
        $client->getPlatformSetting();
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
