<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Client\PaymentScheduleClient;
use Cable8mm\PortonePhp\Exception\InvalidRequestException;
use Cable8mm\PortonePhp\Exception\UnknownException;
use Cable8mm\PortonePhp\Exception\UnrecognizedResponseException;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\Model\CreatePaymentScheduleResponse;
use Cable8mm\PortonePhp\Model\GetPaymentSchedulesResponse;
use Cable8mm\PortonePhp\Model\PaymentSchedule;
use Cable8mm\PortonePhp\Model\RevokePaymentSchedulesResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class PaymentScheduleClientTest extends TestCase
{
    // Minimal schedule object matching the SCHEDULED variant required fields.
    private const SCHEDULE_OBJECT = [
        'status' => 'SCHEDULED',
        'id' => 'schedule-001',
        'merchantId' => 'merchant-1',
        'storeId' => 'store-1',
        'paymentId' => 'payment-001',
        'billingKey' => 'billing-001',
        'orderName' => 'order',
        'isCulturalExpense' => false,
        'isEscrow' => false,
        'customer' => [],
        'customData' => null,
        'totalAmount' => 1004,
        'currency' => 'KRW',
        'createdAt' => '2026-01-01T00:00:00Z',
        'timeToPay' => '2026-01-01T01:00:00Z',
    ];

    private const REVOKED_SCHEDULE_OBJECT = [
        'status' => 'REVOKED',
        'id' => 'schedule-001',
        'merchantId' => 'merchant-1',
        'storeId' => 'store-1',
        'paymentId' => 'payment-001',
        'billingKey' => 'billing-001',
        'orderName' => 'order',
        'isCulturalExpense' => false,
        'isEscrow' => false,
        'customer' => [],
        'customData' => null,
        'totalAmount' => 1004,
        'currency' => 'KRW',
        'createdAt' => '2026-01-01T00:00:00Z',
        'timeToPay' => '2026-01-01T01:00:00Z',
        'revokedAt' => '2026-01-01T00:30:00Z',
    ];

    public function test_create_payment_schedule_returns_typed_response(): void
    {
        $body = json_encode(['schedule' => self::SCHEDULE_OBJECT], JSON_THROW_ON_ERROR);
        $client = $this->scheduleClient(new MockHandler([new Response(200, [], $body)]));

        $result = $client->createPaymentSchedule('payment-001', [], '2026-01-01T01:00:00Z');

        self::assertInstanceOf(CreatePaymentScheduleResponse::class, $result);
        self::assertSame('schedule-001', $result->schedule['id']);
        self::assertSame('SCHEDULED', $result->schedule['status']);
    }

    public function test_create_payment_schedule_async_returns_future(): void
    {
        $body = json_encode(['schedule' => self::SCHEDULE_OBJECT], JSON_THROW_ON_ERROR);
        $client = $this->scheduleClient(new MockHandler([new Response(200, [], $body)]));

        $future = $client->createPaymentScheduleAsync('payment-001', [], '2026-01-01T01:00:00Z');

        self::assertInstanceOf(Future::class, $future);
        $result = $future->wait();
        self::assertInstanceOf(CreatePaymentScheduleResponse::class, $result);
        self::assertSame('schedule-001', $result->schedule['id']);
    }

    public function test_get_payment_schedule_returns_typed_model(): void
    {
        $body = json_encode(self::SCHEDULE_OBJECT, JSON_THROW_ON_ERROR);
        $client = $this->scheduleClient(new MockHandler([new Response(200, [], $body)]));

        $result = $client->getPaymentSchedule('schedule-001');

        self::assertInstanceOf(PaymentSchedule::class, $result);
        self::assertSame('SCHEDULED', $result->variant);
        self::assertSame('schedule-001', $result->data['id']);
    }

    public function test_get_payment_schedule_async_returns_future(): void
    {
        $body = json_encode(self::SCHEDULE_OBJECT, JSON_THROW_ON_ERROR);
        $client = $this->scheduleClient(new MockHandler([new Response(200, [], $body)]));

        $future = $client->getPaymentScheduleAsync('schedule-001');

        self::assertInstanceOf(Future::class, $future);
        $result = $future->wait();
        self::assertInstanceOf(PaymentSchedule::class, $result);
        self::assertSame('SCHEDULED', $result->variant);
    }

    public function test_get_payment_schedules_returns_list_response(): void
    {
        $body = json_encode([
            'items' => [self::SCHEDULE_OBJECT],
            'page' => ['number' => 0, 'size' => 1, 'totalCount' => 1],
        ], JSON_THROW_ON_ERROR);
        $client = $this->scheduleClient(new MockHandler([new Response(200, [], $body)]));

        $result = $client->getPaymentSchedules();

        self::assertInstanceOf(GetPaymentSchedulesResponse::class, $result);
        self::assertCount(1, $result->items);
    }

    public function test_revoke_payment_schedules_returns_typed_response(): void
    {
        $body = json_encode([
            'revokedScheduleIds' => ['schedule-001'],
            'revokedAt' => '2026-01-01T00:30:00Z',
        ], JSON_THROW_ON_ERROR);
        $client = $this->scheduleClient(new MockHandler([new Response(200, [], $body)]));

        $result = $client->revokePaymentSchedules(null, ['schedule-001']);

        self::assertInstanceOf(RevokePaymentSchedulesResponse::class, $result);
        self::assertContains('schedule-001', $result->revokedScheduleIds);
        self::assertSame('2026-01-01T00:30:00Z', $result->revokedAt);
    }

    public function test_revoke_payment_schedules_async_returns_future(): void
    {
        $body = json_encode([
            'revokedScheduleIds' => ['schedule-001'],
            'revokedAt' => '2026-01-01T00:30:00Z',
        ], JSON_THROW_ON_ERROR);
        $client = $this->scheduleClient(new MockHandler([new Response(200, [], $body)]));

        $future = $client->revokePaymentSchedulesAsync(null, ['schedule-001']);

        self::assertInstanceOf(Future::class, $future);
        $result = $future->wait();
        self::assertInstanceOf(RevokePaymentSchedulesResponse::class, $result);
        self::assertContains('schedule-001', $result->revokedScheduleIds);
    }

    public function test_revoked_schedule_status_is_decoded(): void
    {
        $body = json_encode(self::REVOKED_SCHEDULE_OBJECT, JSON_THROW_ON_ERROR);
        $client = $this->scheduleClient(new MockHandler([new Response(200, [], $body)]));

        $result = $client->getPaymentSchedule('schedule-001');

        self::assertInstanceOf(PaymentSchedule::class, $result);
        self::assertSame('REVOKED', $result->variant);
        self::assertSame('2026-01-01T00:30:00Z', $result->data['revokedAt']);
    }

    public function test_defined_error_raises_port_one_exception(): void
    {
        $client = $this->scheduleClient(new MockHandler([
            new Response(400, [], '{"type":"INVALID_REQUEST","message":"bad"}'),
        ]));

        $this->expectException(InvalidRequestException::class);
        $client->getPaymentSchedule('schedule-001');
    }

    public function test_unknown_error_raises_unknown_exception(): void
    {
        $client = $this->scheduleClient(new MockHandler([
            new Response(500, [], 'server error'),
        ]));

        try {
            $client->getPaymentSchedule('schedule-001');
            self::fail('Expected UnknownException.');
        } catch (UnknownException $exception) {
            self::assertSame('getPaymentSchedule', $exception->operation);
        }
    }

    public function test_undecodable_success_raises_unrecognized_response_exception(): void
    {
        $client = $this->scheduleClient(new MockHandler([
            new Response(200, [], 'not-json'),
        ]));

        $this->expectException(UnrecognizedResponseException::class);
        $client->getPaymentSchedule('schedule-001');
    }

    public function test_async_wait_propagates_defined_error(): void
    {
        $client = $this->scheduleClient(new MockHandler([
            new Response(400, [], '{"type":"INVALID_REQUEST","message":"bad"}'),
        ]));

        $this->expectException(InvalidRequestException::class);
        $client->getPaymentScheduleAsync('schedule-001')->wait();
    }

    private function scheduleClient(MockHandler $handler): PaymentScheduleClient
    {
        $stack = HandlerStack::create($handler);
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

        return new PaymentScheduleClient('test-secret', $executor);
    }
}
