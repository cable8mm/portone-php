<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Browser\BrowserBillingKeyRequest;
use PHPUnit\Framework\TestCase;

/**
 * T-067 — Browser billing-key issue values.
 *
 * Covers (key names traced to the @portone/browser-sdk 0.1.13 IssueBillingKeyRequest type definitions):
 *  - toArray uses the documented browser SDK key names and places customerId under customer.customerId.
 *  - Unset optional values are omitted.
 *  - billingKeyMethod, windowType, card, easyPay, and extra pass through untouched.
 *  - An empty issueId or a non-absolute-http(s) redirectUrl throws InvalidArgumentException (ERR-012).
 */
final class BrowserBillingKeyRequestTest extends TestCase
{
    public function test_to_array_returns_documented_keys(): void
    {
        $request = new BrowserBillingKeyRequest(
            storeId: 'store-1',
            channelKey: 'channel-1',
            billingKeyMethod: 'EASY_PAY',
            issueId: 'issue-1',
            issueName: 'Monthly plan',
            redirectUrl: 'https://example.com/billing-key-redirect',
            customerId: 'customer-1',
            displayAmount: 9900,
            currency: 'KRW',
            forceRedirect: true,
            windowType: ['pc' => 'IFRAME', 'mobile' => 'REDIRECTION'],
            card: [],
            easyPay: ['easyPayProvider' => 'KAKAOPAY', 'availablePayMethods' => ['CARD', 'MONEY']],
        );

        $this->assertSame(
            [
                'storeId' => 'store-1',
                'channelKey' => 'channel-1',
                'billingKeyMethod' => 'EASY_PAY',
                'issueId' => 'issue-1',
                'issueName' => 'Monthly plan',
                'redirectUrl' => 'https://example.com/billing-key-redirect',
                'customer' => ['customerId' => 'customer-1'],
                'displayAmount' => 9900,
                'currency' => 'KRW',
                'forceRedirect' => true,
                'windowType' => ['pc' => 'IFRAME', 'mobile' => 'REDIRECTION'],
                'card' => [],
                'easyPay' => ['easyPayProvider' => 'KAKAOPAY', 'availablePayMethods' => ['CARD', 'MONEY']],
            ],
            $request->toArray(),
        );
    }

    public function test_unset_optional_values_are_omitted(): void
    {
        $request = new BrowserBillingKeyRequest(
            storeId: 'store-1',
            channelKey: 'channel-1',
            billingKeyMethod: 'CARD',
            issueId: 'issue-1',
            issueName: 'Monthly plan',
            redirectUrl: 'http://192.168.0.2:3000/billing-key-redirect',
        );

        $this->assertSame(
            [
                'storeId' => 'store-1',
                'channelKey' => 'channel-1',
                'billingKeyMethod' => 'CARD',
                'issueId' => 'issue-1',
                'issueName' => 'Monthly plan',
                'redirectUrl' => 'http://192.168.0.2:3000/billing-key-redirect',
            ],
            $request->toArray(),
        );
    }

    public function test_values_pass_through_without_validation(): void
    {
        $request = new BrowserBillingKeyRequest(
            storeId: 'store-1',
            channelKey: 'channel-1',
            billingKeyMethod: 'FUTURE_METHOD',
            issueId: 'issue-1',
            issueName: 'Monthly plan',
            redirectUrl: 'https://example.com/billing-key-redirect',
            windowType: ['pc' => 'FUTURE_WINDOW'],
            card: ['anything' => ['nested' => 1]],
            easyPay: ['easyPayProvider' => 'FUTURE_PROVIDER', 'availablePayMethods' => ['FUTURE']],
        );

        $parameters = $request->toArray();

        $this->assertSame('FUTURE_METHOD', $parameters['billingKeyMethod']);
        $this->assertSame(['pc' => 'FUTURE_WINDOW'], $parameters['windowType']);
        $this->assertSame(['anything' => ['nested' => 1]], $parameters['card']);
        $this->assertSame(['easyPayProvider' => 'FUTURE_PROVIDER', 'availablePayMethods' => ['FUTURE']], $parameters['easyPay']);
    }

    public function test_extra_keys_are_added_and_documented_values_win(): void
    {
        $request = new BrowserBillingKeyRequest(
            storeId: 'store-1',
            channelKey: 'channel-1',
            billingKeyMethod: 'CARD',
            issueId: 'issue-1',
            issueName: 'Monthly plan',
            redirectUrl: 'https://example.com/billing-key-redirect',
            extra: [
                'bypass' => ['kcp_v2' => ['site_name' => 'Shop']],
                'issueId' => 'issue-from-extra',
            ],
        );

        $this->assertSame(
            [
                'storeId' => 'store-1',
                'channelKey' => 'channel-1',
                'billingKeyMethod' => 'CARD',
                'issueId' => 'issue-1',
                'issueName' => 'Monthly plan',
                'redirectUrl' => 'https://example.com/billing-key-redirect',
                'bypass' => ['kcp_v2' => ['site_name' => 'Shop']],
            ],
            $request->toArray(),
        );
    }

    public function test_empty_issue_id_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new BrowserBillingKeyRequest(
            storeId: 'store-1',
            channelKey: 'channel-1',
            billingKeyMethod: 'CARD',
            issueId: '',
            issueName: 'Monthly plan',
            redirectUrl: 'https://example.com/billing-key-redirect',
        );
    }

    public function test_non_absolute_http_redirect_url_throws(): void
    {
        $invalid = ['', 'billing-key-redirect', '/billing-key-redirect', 'ftp://example.com/redirect'];

        foreach ($invalid as $redirectUrl) {
            try {
                new BrowserBillingKeyRequest(
                    storeId: 'store-1',
                    channelKey: 'channel-1',
                    billingKeyMethod: 'CARD',
                    issueId: 'issue-1',
                    issueName: 'Monthly plan',
                    redirectUrl: $redirectUrl,
                );
                self::fail('Expected an invalid redirectUrl to be rejected.');
            } catch (\InvalidArgumentException) {
                self::assertTrue(true);
            }
        }
    }
}
