<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\BillingKeyInfo;
use Cable8mm\PortonePhp\Model\CashReceipt;
use Cable8mm\PortonePhp\Model\Payment;
use Cable8mm\PortonePhp\Model\PaymentSchedule;
use Cable8mm\PortonePhp\Model\Promotion;
use PHPUnit\Framework\TestCase;

final class DiscriminatedResponseTest extends TestCase
{
    public function test_known_variants_are_classified_without_discarding_payloads(): void
    {
        $responses = [
            [BillingKeyInfo::fromArray(self::payload('status', 'ISSUED', ['billingKey', 'merchantId', 'storeId', 'channels', 'customer', 'issuedAt'])), 'ISSUED'],
            [PaymentSchedule::fromArray(self::payload('status', 'SUCCEEDED', ['id', 'merchantId', 'storeId', 'paymentId', 'billingKey', 'orderName', 'isCulturalExpense', 'isEscrow', 'customer', 'customData', 'totalAmount', 'currency', 'createdAt', 'timeToPay', 'startedAt', 'completedAt'])), 'SUCCEEDED'],
            [CashReceipt::fromArray(self::payload('status', 'ISSUED', ['merchantId', 'storeId', 'paymentId', 'channel', 'amount', 'currency', 'orderName', 'isManual', 'issueNumber', 'issuedAt'])), 'ISSUED'],
            [Payment::fromArray(self::payload('status', 'PAID', ['id', 'transactionId', 'merchantId', 'storeId', 'channel', 'version', 'requestedAt', 'updatedAt', 'statusChangedAt', 'orderName', 'amount', 'currency', 'customer', 'origin', 'paidAt', 'disputes'])), 'PAID'],
            [Promotion::fromArray(self::payload('type', 'CARD', ['id', 'storeId', 'name', 'discountPolicy', 'totalBudget', 'spentAmount', 'currency', 'startAt', 'endAt', 'cardCompany', 'status', 'createdAt', 'recoverOption'])), 'CARD'],
        ];

        foreach ($responses as [$response, $variant]) {
            self::assertTrue($response->knownVariant);
            self::assertSame($variant, $response->variant);
            self::assertSame($variant, $response->data['status'] ?? $response->data['type']);
        }
    }

    public function test_unknown_variants_are_preserved_for_forward_compatibility(): void
    {
        $responses = [
            BillingKeyInfo::fromArray(['status' => 'REPLACED', 'id' => 'billing-key']),
            PaymentSchedule::fromArray(['status' => 'PAUSED', 'id' => 'schedule']),
            CashReceipt::fromArray(['status' => 'REFUNDED', 'id' => 'receipt']),
            Payment::fromArray(['status' => 'REVIEW', 'id' => 'payment']),
            Promotion::fromArray(['type' => 'COUPON', 'id' => 'promotion']),
        ];

        foreach ($responses as $response) {
            self::assertFalse($response->knownVariant);
            self::assertArrayHasKey('id', $response->data);
        }
    }

    public function test_missing_discriminator_is_rejected(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        Payment::fromArray(['id' => 'payment']);
    }

    /** @param list<string> $fields @return array<string,mixed> */
    private static function payload(string $discriminator, string $value, array $fields): array
    {
        return [$discriminator => $value] + array_fill_keys($fields, null);
    }
}
