<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Response\CapturePaymentResponse;
use Cable8mm\PortonePhp\Response\GetAllPaymentEventsByCursorResponse;
use Cable8mm\PortonePhp\Response\GetAllPaymentsByCursorResponse;
use Cable8mm\PortonePhp\Response\PreRegisterPaymentResponse;
use Cable8mm\PortonePhp\Response\ResendWebhookResponse;
use PHPUnit\Framework\TestCase;

final class PaymentSimpleResponseTest extends TestCase
{
    public function test_cursor_and_webhook_responses_expose_their_payloads(): void
    {
        self::assertSame(
            [['id' => 'event-id']],
            GetAllPaymentEventsByCursorResponse::fromArray(['items' => [['id' => 'event-id']]])->items,
        );
        self::assertSame(
            [['id' => 'payment-id']],
            GetAllPaymentsByCursorResponse::fromArray(['items' => [['id' => 'payment-id']]])->items,
        );
        self::assertSame(
            ['id' => 'webhook-id'],
            ResendWebhookResponse::fromArray(['webhook' => ['id' => 'webhook-id']])->webhook,
        );
    }

    public function test_empty_success_responses_decode_without_fields(): void
    {
        self::assertInstanceOf(CapturePaymentResponse::class, CapturePaymentResponse::fromArray(['ignored' => true]));
        self::assertInstanceOf(PreRegisterPaymentResponse::class, PreRegisterPaymentResponse::fromArray([]));
    }

    public function test_simple_payment_responses_reject_invalid_shapes(): void
    {
        $cases = [
            static fn (): mixed => GetAllPaymentEventsByCursorResponse::fromArray(['items' => ['invalid']]),
            static fn (): mixed => GetAllPaymentsByCursorResponse::fromArray(['items' => 'invalid']),
            static fn (): mixed => ResendWebhookResponse::fromArray(['webhook' => 'invalid']),
        ];

        foreach ($cases as $case) {
            try {
                $case();
                self::fail('Expected an invalid response shape to be rejected.');
            } catch (\UnexpectedValueException) {
                self::assertTrue(true);
            }
        }
    }
}
