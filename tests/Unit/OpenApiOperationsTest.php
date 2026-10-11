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
use Cable8mm\PortonePhp\Response\PaymentSessionAgreement;
use Cable8mm\PortonePhp\Response\PaymentSessionColors;
use Cable8mm\PortonePhp\Response\PaymentSessionProduct;
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
            new Response(200, [], '{"items":[{"bank":"SHINHAN","name":{"ko":"신한은행"}}]}'),
            new Response(200, [], '{"methods":[{"paymentMethod":"CARD","channelKey":"channel-key"}]}'),
        ]), $history);

        $banks = $client->common->getBankInfos();
        self::assertInstanceOf(GetBankInfosResponse::class, $banks);
        self::assertSame('SHINHAN', $banks->items[0]->bank);
        self::assertSame('신한은행', $banks->items[0]->name->ko);
        $checkout = $client->checkout->evaluateCheckoutProfile('profile-key', 'KR', 'KRW', 1000);
        self::assertInstanceOf(EvaluateCheckoutProfileResponse::class, $checkout);
        self::assertSame('CARD', $checkout->methods[0]->paymentMethod);
        self::assertStringContainsString('/banks', (string) $history[0]['request']->getUri());
        self::assertStringContainsString('profileKey=profile-key', (string) $history[1]['request']->getUri());
    }

    public function test_payment_session_operations_support_sync_and_async_calls(): void
    {
        $client = $this->client(new MockHandler([
            new Response(200, [], '{"sessionId":"session-id","url":"https://example.test/session","expiresAt":"2026-10-12T00:00:00Z"}'),
            new Response(200, [], '{"id":"session-id","storeId":"store-id","paymentId":"payment-id","profileKey":"profile-key","country":"KR","currency":"KRW","totalAmount":1000,"orderName":"Order","products":[{"name":"Book","unitPrice":1000,"quantity":1}],"agreements":[{"name":"Terms","url":"https://example.test/terms"}],"colors":{"primary":"#000000"},"createdAt":"2026-10-12T00:00:00Z","expiresAt":"2026-10-12T01:00:00Z"}'),
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
        $session = $client->paymentSession->getPaymentSessionAsync('session-id')->wait();
        self::assertInstanceOf(PaymentSession::class, $session);
        self::assertInstanceOf(PaymentSessionProduct::class, $session->products[0]);
        self::assertInstanceOf(PaymentSessionAgreement::class, $session->agreements[0]);
        self::assertInstanceOf(PaymentSessionColors::class, $session->colors);
        self::assertSame('#000000', $session->colors->primary);
        self::assertInstanceOf(ClosePaymentSessionResponse::class, $client->paymentSession->closePaymentSession('session-id'));
    }

    public function test_openapi_optional_fields_are_absent_or_typed_but_not_null(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        PaymentSession::fromArray([
            'id' => 'session-id',
            'storeId' => 'store-id',
            'paymentId' => 'payment-id',
            'profileKey' => 'profile-key',
            'country' => 'KR',
            'currency' => 'KRW',
            'totalAmount' => 1000,
            'orderName' => 'Order',
            'redirectUrl' => null,
            'createdAt' => '2026-10-12T00:00:00Z',
            'expiresAt' => '2026-10-12T01:00:00Z',
        ]);
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
