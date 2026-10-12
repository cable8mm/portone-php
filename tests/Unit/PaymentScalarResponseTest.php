<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\ApplyEscrowLogisticsResponse;
use Cable8mm\PortonePhp\Model\CloseVirtualAccountResponse;
use Cable8mm\PortonePhp\Model\ConfirmEscrowResponse;
use Cable8mm\PortonePhp\Model\ModifyEscrowLogisticsResponse;
use Cable8mm\PortonePhp\Model\PaymentWebhookResponse;
use Cable8mm\PortonePhp\Model\RegisterStoreReceiptResponse;
use Cable8mm\PortonePhp\Model\StopPaymentCancellationResponse;
use PHPUnit\Framework\TestCase;

final class PaymentScalarResponseTest extends TestCase
{
    public function test_scalar_payment_responses_expose_typed_fields(): void
    {
        $escrow = ApplyEscrowLogisticsResponse::fromArray([
            'invoiceNumber' => 'invoice',
            'sentAt' => '2026-01-01T00:00:00Z',
            'appliedAt' => '2026-01-01T00:00:01Z',
        ]);
        self::assertSame('invoice', $escrow->invoiceNumber);
        self::assertSame('2026-01-01T00:00:01Z', $escrow->appliedAt);

        self::assertSame('closed', CloseVirtualAccountResponse::fromArray(['closedAt' => 'closed'])->closedAt);
        self::assertSame('completed', ConfirmEscrowResponse::fromArray(['completedAt' => 'completed'])->completedAt);
        self::assertSame('modified', ModifyEscrowLogisticsResponse::fromArray([
            'invoiceNumber' => 'invoice',
            'sentAt' => 'sent',
            'modifiedAt' => 'modified',
        ])->modifiedAt);
        self::assertSame('stopped', StopPaymentCancellationResponse::fromArray(['stoppedAt' => 'stopped'])->stoppedAt);
    }

    public function test_nullable_receipt_url_and_webhook_response_are_decoded(): void
    {
        self::assertNull(RegisterStoreReceiptResponse::fromArray([])->receiptUrl);
        self::assertSame('https://example.test/receipt', RegisterStoreReceiptResponse::fromArray([
            'receiptUrl' => 'https://example.test/receipt',
        ])->receiptUrl);

        $webhook = PaymentWebhookResponse::fromArray([
            'code' => '200',
            'header' => 'content-type: application/json',
            'body' => '{}',
            'respondedAt' => '2026-01-01T00:00:00Z',
        ]);
        self::assertSame('200', $webhook->code);
        self::assertSame('{}', $webhook->body);
    }

    public function test_required_scalar_fields_reject_invalid_values(): void
    {
        $cases = [
            static fn (): mixed => ApplyEscrowLogisticsResponse::fromArray([]),
            static fn (): mixed => CloseVirtualAccountResponse::fromArray(['closedAt' => 1]),
            static fn (): mixed => ConfirmEscrowResponse::fromArray(['completedAt' => null]),
            static fn (): mixed => ModifyEscrowLogisticsResponse::fromArray([]),
            static fn (): mixed => RegisterStoreReceiptResponse::fromArray(['receiptUrl' => 1]),
            static fn (): mixed => StopPaymentCancellationResponse::fromArray([]),
            static fn (): mixed => PaymentWebhookResponse::fromArray([]),
        ];

        foreach ($cases as $case) {
            try {
                $case();
                self::fail('Expected an invalid scalar response to be rejected.');
            } catch (\UnexpectedValueException) {
                self::assertTrue(true);
            }
        }
    }
}
