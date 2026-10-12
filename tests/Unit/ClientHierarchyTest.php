<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Client\AccountClient;
use Cable8mm\PortonePhp\Client\AccountTransferClient;
use Cable8mm\PortonePhp\Client\AdditionalFeatureClient;
use Cable8mm\PortonePhp\Client\AuthClient;
use Cable8mm\PortonePhp\Client\B2bClient;
use Cable8mm\PortonePhp\Client\BillingKeyClient;
use Cable8mm\PortonePhp\Client\BulkAccountTransferClient;
use Cable8mm\PortonePhp\Client\BulkPayoutClient;
use Cable8mm\PortonePhp\Client\CashReceiptClient;
use Cable8mm\PortonePhp\Client\CheckoutClient;
use Cable8mm\PortonePhp\Client\CommonClient;
use Cable8mm\PortonePhp\Client\CompanyClient;
use Cable8mm\PortonePhp\Client\CounterpartyClient;
use Cable8mm\PortonePhp\Client\IdentityVerificationClient;
use Cable8mm\PortonePhp\Client\PartnerClient;
use Cable8mm\PortonePhp\Client\PartnerSettlementClient;
use Cable8mm\PortonePhp\Client\PaymentClient;
use Cable8mm\PortonePhp\Client\PaymentScheduleClient;
use Cable8mm\PortonePhp\Client\PaymentSessionClient;
use Cable8mm\PortonePhp\Client\PayoutClient;
use Cable8mm\PortonePhp\Client\PgSpecificClient;
use Cable8mm\PortonePhp\Client\PlatformClient;
use Cable8mm\PortonePhp\Client\PolicyClient;
use Cable8mm\PortonePhp\Client\PortOneClient;
use Cable8mm\PortonePhp\Client\PromotionClient;
use Cable8mm\PortonePhp\Client\ReconciliationClient;
use Cable8mm\PortonePhp\Client\TaxInvoiceClient;
use Cable8mm\PortonePhp\Client\TransferClient;
use PHPUnit\Framework\TestCase;

final class ClientHierarchyTest extends TestCase
{
    public function test_root_exposes_exactly_the_required_accessors(): void
    {
        $client = new PortOneClient('test-secret');

        self::assertInstanceOf(PaymentClient::class, $client->payment);
        self::assertInstanceOf(IdentityVerificationClient::class, $client->identityVerification);
        self::assertInstanceOf(PgSpecificClient::class, $client->pgSpecific);
        self::assertInstanceOf(AuthClient::class, $client->auth);
        self::assertInstanceOf(ReconciliationClient::class, $client->reconciliation);
        self::assertInstanceOf(PlatformClient::class, $client->platform);
        self::assertInstanceOf(B2bClient::class, $client->b2b);
        self::assertInstanceOf(CommonClient::class, $client->common);
        self::assertInstanceOf(CheckoutClient::class, $client->checkout);
        self::assertInstanceOf(PaymentSessionClient::class, $client->paymentSession);
        $names = array_keys(get_object_vars($client));
        sort($names);
        self::assertSame(['auth', 'b2b', 'checkout', 'common', 'identityVerification', 'payment', 'paymentSession', 'pgSpecific', 'platform', 'reconciliation'], $names);
    }

    public function test_payment_platform_and_b2b_expose_exactly_the_required_children(): void
    {
        $payment = new PaymentClient('test-secret');
        $paymentNames = array_keys(get_object_vars($payment));
        sort($paymentNames);
        self::assertSame(['additionalFeature', 'billingKey', 'cashReceipt', 'paymentSchedule', 'promotion'], $paymentNames);

        $platform = new PlatformClient('test-secret');
        $platformNames = array_keys(get_object_vars($platform));
        sort($platformNames);
        self::assertSame(['account', 'accountTransfer', 'bulkAccountTransfer', 'bulkPayout', 'company', 'partner', 'partnerSettlement', 'payout', 'policy', 'transfer'], $platformNames);

        $b2b = new B2bClient('test-secret');
        $b2bNames = array_keys(get_object_vars($b2b));
        sort($b2bNames);
        self::assertSame(['counterparty', 'taxInvoice'], $b2bNames);
    }

    public function test_parent_and_all_children_share_one_request_executor(): void
    {
        $root = new PortOneClient('test-secret');
        $executor = $this->executor($root);

        self::assertSame($executor, $this->executor($root->payment));
        self::assertSame($executor, $this->executor($root->payment->billingKey));
        self::assertSame($executor, $this->executor($root->platform));
        self::assertSame($executor, $this->executor($root->platform->transfer));
        self::assertSame($executor, $this->executor($root->b2b));
        self::assertSame($executor, $this->executor($root->common));
        self::assertSame($executor, $this->executor($root->checkout));
        self::assertSame($executor, $this->executor($root->paymentSession));
        self::assertSame($executor, $this->executor($root->b2b->counterparty));
    }

    public function test_every_client_can_be_constructed_independently(): void
    {
        foreach ($this->clientClasses() as $clientClass) {
            self::assertInstanceOf($clientClass, new $clientClass('test-secret'));
        }
    }

    public function test_empty_api_secret_is_rejected_before_requests(): void
    {
        foreach ($this->clientClasses() as $clientClass) {
            try {
                new $clientClass('');
                self::fail($clientClass.' accepted an empty apiSecret.');
            } catch (\InvalidArgumentException) {
                self::assertTrue(true);
            }
        }
    }

    /** @return list<class-string> */
    private function clientClasses(): array
    {
        return [
            PaymentClient::class,
            BillingKeyClient::class,
            CashReceiptClient::class,
            AdditionalFeatureClient::class,
            PaymentScheduleClient::class,
            PromotionClient::class,
            IdentityVerificationClient::class,
            PgSpecificClient::class,
            AuthClient::class,
            ReconciliationClient::class,
            PlatformClient::class,
            CompanyClient::class,
            AccountTransferClient::class,
            PolicyClient::class,
            AccountClient::class,
            BulkAccountTransferClient::class,
            BulkPayoutClient::class,
            PayoutClient::class,
            PartnerSettlementClient::class,
            PartnerClient::class,
            TransferClient::class,
            B2bClient::class,
            TaxInvoiceClient::class,
            CounterpartyClient::class,
        ];
    }

    private function executor(object $client): object
    {
        $property = (new \ReflectionClass($client))->getParentClass()->getProperty('executor');
        $property->setAccessible(true);

        return $property->getValue($client);
    }
}
