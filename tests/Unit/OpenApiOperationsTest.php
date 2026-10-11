<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\PortOneClient;
use Cable8mm\PortonePhp\Response\ClosePaymentSessionResponse;
use Cable8mm\PortonePhp\Response\CreatePaymentSessionResponse;
use Cable8mm\PortonePhp\Response\EvaluateCheckoutProfileResponse;
use Cable8mm\PortonePhp\Response\GetBankInfosResponse;
use Cable8mm\PortonePhp\Response\PaymentSession;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class OpenApiOperationsTest extends TestCase
{
    public function test_common_and_checkout_operations_decode_openapi_responses(): void
    {
        $history = [];
        $client = $this->client(new MockHandler([
            new Response(200, [], '{"items":[{"bankCode":"SHINHAN"}]}'),
            new Response(200, [], '{"methods":[{"paymentMethod":"CARD","channelKey":"channel-key"}]}'),
        ]), $history);

        self::assertInstanceOf(GetBankInfosResponse::class, $client->common->getBankInfos());
        self::assertInstanceOf(EvaluateCheckoutProfileResponse::class, $client->checkout->evaluateCheckoutProfile('profile-key', 'KR', 'KRW', 1000));
        self::assertStringContainsString('/banks', (string) $history[0]['request']->getUri());
        self::assertStringContainsString('profileKey=profile-key', (string) $history[1]['request']->getUri());
    }

    public function test_payment_session_operations_support_sync_and_async_calls(): void
    {
        $client = $this->client(new MockHandler([
            new Response(200, [], '{"sessionId":"session-id","url":"https://example.test/session","expiresAt":"2026-10-12T00:00:00Z"}'),
            new Response(200, [], '{"id":"session-id","storeId":"store-id","paymentId":"payment-id","profileKey":"profile-key","country":"KR","currency":"KRW","totalAmount":1000,"orderName":"Order","createdAt":"2026-10-12T00:00:00Z","expiresAt":"2026-10-12T01:00:00Z"}'),
            new Response(200, [], '{"closedAt":"2026-10-12T00:30:00Z"}'),
        ]));

        self::assertInstanceOf(CreatePaymentSessionResponse::class, $client->paymentSession->createPaymentSession(
            'store-id',
            'payment-id',
            'profile-key',
            null,
            'KR',
            'KRW',
            1000,
            'Order',
        ));
        self::assertInstanceOf(PaymentSession::class, $client->paymentSession->getPaymentSessionAsync('session-id')->wait());
        self::assertInstanceOf(ClosePaymentSessionResponse::class, $client->paymentSession->closePaymentSession('session-id'));
    }

    /** @param array<int,array<string,mixed>> $history */
    private function client(MockHandler $handler, array &$history = []): PortOneClient
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

        return new PortOneClient('test-secret', $executor);
    }
}
