<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Client\PaymentClient;
use Cable8mm\PortonePhp\Exception\UnknownException;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\Model\CancelPaymentResponse;
use Cable8mm\PortonePhp\Model\PaymentCancellation;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * Unit tests for T-052: Partial cancellation and refund paths.
 *
 * Covers:
 *  - Request construction for every cancellation field (amount, taxFreeAmount, vatAmount,
 *    currentCancellableAmount, reason, requester, skipWebhook).
 *  - Typed CancelPaymentResponse / PaymentCancellation decoded correctly from mocked responses.
 *  - Error types CANCEL_AMOUNT_EXCEEDS_CANCELLABLE_AMOUNT,
 *    CANCELLABLE_AMOUNT_CONSISTENCY_BROKEN, PAYMENT_ALREADY_CANCELLED each preserved in
 *    UnknownException.errorType (AC-018 / ERR-003 / ERR-004).
 */
final class PartialCancellationClientTest extends TestCase
{
    // ─── request construction ───────────────────────────────────────────────

    public function test_partial_cancel_sends_amount_taxfreeamount_vatamount_in_json_body(): void
    {
        $history = [];
        $client = $this->paymentClient(new MockHandler([
            new Response(200, [], $this->cancellationResponseJson('partial-cancel-1', 500, 0, 0, 'SUCCEEDED')),
        ]), $history);

        $result = $client->cancelPayment(
            paymentId: 'pay-001',
            amount: 500,
            taxFreeAmount: 0,
            vatAmount: 0,
            reason: 'partial refund step 1',
            skipWebhook: true,
        );

        self::assertCount(1, $history);
        /** @var RequestInterface $req */
        $req = $history[0]['request'];
        $body = json_decode((string) $req->getBody(), true);
        self::assertSame(500, $body['amount']);
        self::assertSame(0, $body['taxFreeAmount']);
        self::assertSame(0, $body['vatAmount']);
        self::assertSame('partial refund step 1', $body['reason']);
        self::assertTrue($body['skipWebhook']);
        self::assertStringContainsString('/payments/pay-001/cancel', (string) $req->getUri()->getPath());

        self::assertInstanceOf(CancelPaymentResponse::class, $result);
        self::assertInstanceOf(PaymentCancellation::class, $result->cancellation);
        self::assertSame('SUCCEEDED', $result->cancellation->variant);
        self::assertSame(500, $result->cancellation->data['totalAmount']);
    }

    public function test_partial_cancel_sends_current_cancellable_amount_in_body(): void
    {
        $history = [];
        $client = $this->paymentClient(new MockHandler([
            new Response(200, [], $this->cancellationResponseJson('partial-cancel-2', 500, 0, 0, 'SUCCEEDED')),
        ]), $history);

        $client->cancelPayment(
            paymentId: 'pay-002',
            amount: 500,
            currentCancellableAmount: 1000,
            reason: 'partial refund with guard',
        );

        self::assertCount(1, $history);
        $body = json_decode((string) $history[0]['request']->getBody(), true);
        self::assertSame(500, $body['amount']);
        self::assertSame(1000, $body['currentCancellableAmount']);
    }

    public function test_partial_cancel_without_amount_sends_full_cancel(): void
    {
        $history = [];
        $client = $this->paymentClient(new MockHandler([
            new Response(200, [], $this->cancellationResponseJson('full-cancel-1', 1000, 0, 0, 'SUCCEEDED')),
        ]), $history);

        $client->cancelPayment(paymentId: 'pay-003', reason: 'full cancel');

        $body = json_decode((string) $history[0]['request']->getBody(), true);
        self::assertArrayNotHasKey('amount', $body);
        self::assertArrayNotHasKey('taxFreeAmount', $body);
        self::assertArrayNotHasKey('vatAmount', $body);
        self::assertArrayNotHasKey('currentCancellableAmount', $body);
    }

    public function test_partial_cancel_requester_field_is_sent(): void
    {
        $history = [];
        $client = $this->paymentClient(new MockHandler([
            new Response(200, [], $this->cancellationResponseJson('req-cancel-1', 200, 0, 0, 'REQUESTED')),
        ]), $history);

        $client->cancelPayment(
            paymentId: 'pay-004',
            amount: 200,
            reason: 'admin initiated',
            requester: 'ADMIN',
        );

        $body = json_decode((string) $history[0]['request']->getBody(), true);
        self::assertSame('ADMIN', $body['requester']);
    }

    public function test_partial_cancel_response_has_tax_and_vat_fields(): void
    {
        $client = $this->paymentClient(new MockHandler([
            new Response(200, [], json_encode([
                'cancellation' => [
                    'status' => 'SUCCEEDED',
                    'id' => 'cancel-tax-1',
                    'totalAmount' => 1100,
                    'taxFreeAmount' => 100,
                    'vatAmount' => 100,
                    'reason' => 'tax-aware refund',
                    'requestedAt' => '2026-10-12T00:00:00Z',
                ],
            ], JSON_THROW_ON_ERROR)),
        ]));

        $result = $client->cancelPayment(paymentId: 'pay-005', amount: 1100, taxFreeAmount: 100, vatAmount: 100, reason: 'tax-aware refund');

        self::assertSame(1100, $result->cancellation->data['totalAmount']);
        self::assertSame(100, $result->cancellation->data['taxFreeAmount']);
        self::assertSame(100, $result->cancellation->data['vatAmount']);
    }

    public function test_partial_cancel_failed_status_is_decoded(): void
    {
        $client = $this->paymentClient(new MockHandler([
            new Response(200, [], $this->cancellationResponseJson('failed-cancel-1', 0, 0, 0, 'FAILED')),
        ]));

        $result = $client->cancelPayment(paymentId: 'pay-006', amount: 500, reason: 'test');
        self::assertSame('FAILED', $result->cancellation->variant);
    }

    public function test_partial_cancel_requested_status_is_decoded(): void
    {
        $client = $this->paymentClient(new MockHandler([
            new Response(200, [], $this->cancellationResponseJson('req-cancel-2', 300, 0, 0, 'REQUESTED')),
        ]));

        $result = $client->cancelPayment(paymentId: 'pay-007', amount: 300, reason: 'pending');
        self::assertSame('REQUESTED', $result->cancellation->variant);
    }

    // ─── error type preservation (AC-018 / ERR-003 / ERR-004) ──────────────

    public function test_cancel_amount_exceeds_cancellable_raises_unknown_exception_with_type_preserved(): void
    {
        $body = '{"type":"CANCEL_AMOUNT_EXCEEDS_CANCELLABLE_AMOUNT","message":"취소 금액이 취소 가능 금액을 초과하였습니다."}';
        $client = $this->paymentClient(new MockHandler([new Response(400, [], $body)]));

        try {
            $client->cancelPayment(paymentId: 'pay-err-1', amount: 99999, reason: 'over-cancel');
            self::fail('Expected UnknownException.');
        } catch (UnknownException $exception) {
            self::assertSame('CANCEL_AMOUNT_EXCEEDS_CANCELLABLE_AMOUNT', $exception->errorType);
            self::assertSame(400, $exception->status);
            self::assertSame($body, $exception->responseBody);
            self::assertSame('cancelPayment', $exception->operation);
        }
    }

    public function test_cancellable_amount_consistency_broken_raises_unknown_exception_with_type_preserved(): void
    {
        $body = '{"type":"CANCELLABLE_AMOUNT_CONSISTENCY_BROKEN","message":"취소 가능 잔액이 일치하지 않습니다."}';
        $client = $this->paymentClient(new MockHandler([new Response(409, [], $body)]));

        try {
            $client->cancelPayment(paymentId: 'pay-err-2', amount: 500, currentCancellableAmount: 999, reason: 'mismatch');
            self::fail('Expected UnknownException.');
        } catch (UnknownException $exception) {
            self::assertSame('CANCELLABLE_AMOUNT_CONSISTENCY_BROKEN', $exception->errorType);
            self::assertSame(409, $exception->status);
            self::assertSame($body, $exception->responseBody);
        }
    }

    public function test_payment_already_cancelled_raises_unknown_exception_with_type_preserved(): void
    {
        $body = '{"type":"PAYMENT_ALREADY_CANCELLED","message":"이미 취소된 결제입니다."}';
        $client = $this->paymentClient(new MockHandler([new Response(409, [], $body)]));

        try {
            $client->cancelPayment(paymentId: 'pay-err-3', reason: 'double cancel');
            self::fail('Expected UnknownException.');
        } catch (UnknownException $exception) {
            self::assertSame('PAYMENT_ALREADY_CANCELLED', $exception->errorType);
            self::assertSame(409, $exception->status);
            self::assertSame($body, $exception->responseBody);
        }
    }

    // ─── helpers ────────────────────────────────────────────────────────────

    private function cancellationResponseJson(
        string $id,
        int $totalAmount,
        int $taxFreeAmount,
        int $vatAmount,
        string $status,
    ): string {
        return json_encode([
            'cancellation' => [
                'status' => $status,
                'id' => $id,
                'totalAmount' => $totalAmount,
                'taxFreeAmount' => $taxFreeAmount,
                'vatAmount' => $vatAmount,
                'reason' => 'test',
                'requestedAt' => '2026-10-12T00:00:00Z',
            ],
        ], JSON_THROW_ON_ERROR);
    }

    /** @param list<array{request:RequestInterface, options:array<string,mixed>}> $history */
    private function paymentClient(MockHandler $handler, array &$history = []): PaymentClient
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
