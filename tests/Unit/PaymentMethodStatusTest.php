<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\Payment;
use Cable8mm\PortonePhp\Model\PaymentMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * T-055 — Payment method and status union fixtures.
 *
 * Covers:
 *  - Every payment status value decodes without error; variant and knownVariant reflect the status.
 *  - Unknown status value decodes without error; knownVariant is false, payload preserved.
 *  - Every payment method type decodes into a typed PaymentMethod with variant and knownVariant set.
 *  - Unknown method type decodes without error; PaymentMethod.knownVariant is false, payload preserved.
 *  - Payment with no method field has method=null.
 *  - All method fixture payloads decode correctly (sanitized fixtures regression).
 *  - All status fixture payloads decode correctly (sanitized fixtures regression).
 */
final class PaymentMethodStatusTest extends TestCase
{
    // ─── payment status ───────────────────────────────────────────────────

    #[DataProvider('knownStatusProvider')]
    public function test_known_payment_status_decodes_correctly(string $status): void
    {
        $data = $this->minimalPayment($status);
        $payment = Payment::fromArray($data);

        self::assertSame($status, $payment->variant);
        self::assertTrue($payment->knownVariant);
        self::assertNull($payment->method);
    }

    /** @return list<array{string}> */
    public static function knownStatusProvider(): array
    {
        return [
            ['CANCELLED'],
            ['FAILED'],
            ['PAID'],
            ['PARTIAL_CANCELLED'],
            ['PAY_PENDING'],
            ['READY'],
            ['VIRTUAL_ACCOUNT_ISSUED'],
        ];
    }

    public function test_unknown_status_decodes_without_error_and_preserves_payload(): void
    {
        $data = $this->minimalUnknownStatusPayment('UNKNOWN_FUTURE_STATUS');
        $payment = Payment::fromArray($data);

        self::assertSame('UNKNOWN_FUTURE_STATUS', $payment->variant);
        self::assertFalse($payment->knownVariant);
        self::assertSame('UNKNOWN_FUTURE_STATUS', $payment->data['status']);
    }

    // ─── payment method ───────────────────────────────────────────────────

    #[DataProvider('knownMethodTypeProvider')]
    public function test_known_method_type_decodes_to_payment_method(string $methodType): void
    {
        $data = $this->paidPaymentWithMethod(['type' => $methodType]);
        $payment = Payment::fromArray($data);

        self::assertInstanceOf(PaymentMethod::class, $payment->method);
        self::assertSame($methodType, $payment->method->variant);
        self::assertTrue($payment->method->knownVariant);
    }

    /** @return list<array{string}> */
    public static function knownMethodTypeProvider(): array
    {
        return array_map(static fn (string $t): array => [$t], PaymentMethod::KNOWN_TYPES);
    }

    public function test_unknown_method_type_decodes_without_error(): void
    {
        $data = $this->paidPaymentWithMethod(['type' => 'UnknownFutureMethodType', 'data' => ['futureField' => 'value']]);
        $payment = Payment::fromArray($data);

        self::assertInstanceOf(PaymentMethod::class, $payment->method);
        self::assertSame('UnknownFutureMethodType', $payment->method->variant);
        self::assertFalse($payment->method->knownVariant);
        self::assertSame('value', $payment->method->data['data']['futureField']);
    }

    public function test_payment_without_method_field_has_null_method(): void
    {
        $data = $this->minimalPayment('PAID');   // no 'method' key
        $payment = Payment::fromArray($data);

        self::assertNull($payment->method);
    }

    public function test_method_null_value_results_in_null_method(): void
    {
        $data = array_merge($this->minimalPayment('PAID'), ['method' => null]);
        $payment = Payment::fromArray($data);

        self::assertNull($payment->method);
    }

    // ─── fixture regression ───────────────────────────────────────────────

    public function test_all_method_fixtures_decode_correctly(): void
    {
        $fixtures = $this->loadFixtures();
        $commonFields = $fixtures['common_fields'];
        $methodFixtures = $fixtures['method_fixtures'];

        foreach ($methodFixtures as $methodType => $methodData) {
            $data = array_merge($commonFields, [
                'status' => 'PAID',
                'paidAt' => '2026-10-12T15:00:01Z',
                'method' => $methodData,
            ]);

            $payment = Payment::fromArray($data);

            self::assertInstanceOf(PaymentMethod::class, $payment->method, "Method $methodType not decoded as PaymentMethod.");
            self::assertSame($methodData['type'], $payment->method->variant, "Method type mismatch for $methodType.");
            self::assertSame(
                in_array($methodType, PaymentMethod::KNOWN_TYPES, true),
                $payment->method->knownVariant,
                "knownVariant mismatch for $methodType.",
            );
        }
    }

    public function test_all_status_fixtures_payload_is_preserved(): void
    {
        $fixtures = $this->loadFixtures();
        $commonFields = $fixtures['common_fields'];

        foreach ($fixtures['_payment_status_values'] as $status) {
            $data = array_merge($commonFields, ['status' => $status]);
            // Add status-specific required fields for known statuses
            if ($status === 'PAID') {
                $data['paidAt'] = '2026-10-12T15:00:01Z';
            } elseif ($status === 'CANCELLED' || $status === 'PARTIAL_CANCELLED') {
                $data['cancellations'] = [];
                $data['cancelledAt'] = '2026-10-12T15:01:00Z';
            } elseif ($status === 'FAILED') {
                $data['failedAt'] = '2026-10-12T15:01:00Z';
                $data['failure'] = ['reason' => 'fixture failure', 'pgCode' => 'FIXTURE_CODE'];
                // FAILED doesn't require channel
                unset($data['channel']);
            }

            $payment = Payment::fromArray($data);

            self::assertSame($status, $payment->variant);
            self::assertSame($status, $payment->data['status']);
        }
    }

    // ─── PaymentMethod standalone ─────────────────────────────────────────

    public function test_payment_method_card_fields_are_accessible(): void
    {
        $fixtures = $this->loadFixtures();
        $cardData = $fixtures['method_fixtures']['PaymentMethodCard'];

        $method = PaymentMethod::fromArray($cardData);

        self::assertSame('PaymentMethodCard', $method->variant);
        self::assertTrue($method->knownVariant);
        self::assertSame('fixture-card-number', $method->data['number']);
        self::assertSame(0, $method->data['installmentMonths']);
    }

    public function test_payment_method_easy_pay_provider_is_accessible(): void
    {
        $fixtures = $this->loadFixtures();
        $epData = $fixtures['method_fixtures']['PaymentMethodEasyPay'];

        $method = PaymentMethod::fromArray($epData);

        self::assertSame('PaymentMethodEasyPay', $method->variant);
        self::assertSame('KAKAOPAY', $method->data['provider']);
    }

    public function test_payment_method_virtual_account_fields_accessible(): void
    {
        $fixtures = $this->loadFixtures();
        $vaData = $fixtures['method_fixtures']['PaymentMethodVirtualAccount'];

        $method = PaymentMethod::fromArray($vaData);

        self::assertSame('PaymentMethodVirtualAccount', $method->variant);
        self::assertSame('fixture-account-number', $method->data['accountNumber']);
    }

    public function test_payment_method_mobile_carrier_accessible(): void
    {
        $fixtures = $this->loadFixtures();
        $mobileData = $fixtures['method_fixtures']['PaymentMethodMobile'];

        $method = PaymentMethod::fromArray($mobileData);

        self::assertSame('PaymentMethodMobile', $method->variant);
        self::assertSame('SKT', $method->data['carrier']);
    }

    public function test_payment_method_gift_certificate_type_accessible(): void
    {
        $fixtures = $this->loadFixtures();
        $gcData = $fixtures['method_fixtures']['PaymentMethodGiftCertificate'];

        $method = PaymentMethod::fromArray($gcData);

        self::assertSame('PaymentMethodGiftCertificate', $method->variant);
        self::assertSame('BOOKNLIFE', $method->data['giftCertificateType']);
    }

    // ─── helpers ─────────────────────────────────────────────────────────

    /** @return array<string,mixed> */
    private function minimalPayment(string $status): array
    {
        $base = [
            'status' => $status,
            'id' => 'test-id',
            'transactionId' => 'test-tx-id',
            'merchantId' => 'test-merchant',
            'storeId' => 'test-store',
            'version' => 'V2',
            'requestedAt' => '2026-10-12T15:00:00Z',
            'updatedAt' => '2026-10-12T15:00:01Z',
            'statusChangedAt' => '2026-10-12T15:00:01Z',
            'orderName' => 'test order',
            'amount' => ['total' => 1000, 'taxFree' => 0],
            'currency' => 'KRW',
            'customer' => ['id' => 'cust-01'],
            'origin' => ['platformType' => 'WEB'],
            'channel' => ['type' => 'LIVE'],
        ];

        return match ($status) {
            'CANCELLED', 'PARTIAL_CANCELLED' => array_merge($base, ['cancellations' => [], 'cancelledAt' => '2026-10-12T15:01:00Z']),
            'FAILED' => array_merge(array_diff_key($base, ['channel' => true]), ['failedAt' => '2026-10-12T15:01:00Z', 'failure' => ['reason' => 'test']]),
            'PAID' => array_merge($base, ['paidAt' => '2026-10-12T15:00:01Z', 'disputes' => []]),
            default => $base,
        };
    }

    /** @return array<string,mixed> */
    private function minimalUnknownStatusPayment(string $status): array
    {
        return [
            'status' => $status,
            'id' => 'test-id',
            'transactionId' => 'test-tx-id',
        ];
    }

    /** @return array<string,mixed> */
    private function paidPaymentWithMethod(array $method): array
    {
        return array_merge($this->minimalPayment('PAID'), ['method' => $method]);
    }

    /** @return array<string,mixed> */
    private function loadFixtures(): array
    {
        return json_decode(
            (string) file_get_contents(__DIR__.'/../../tests/fixtures/payment-method-status-fixtures.json'),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
    }
}
