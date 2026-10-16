<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Browser\BrowserPaymentRequest;
use PHPUnit\Framework\TestCase;

/**
 * T-063 — Browser redirect result and payment-request values.
 *
 * Covers:
 *  - toArray uses the documented browser SDK key names and omits unset optional values.
 *  - windowType passes through untouched.
 *  - A missing or non-absolute-http(s) redirectUrl throws InvalidArgumentException (ERR-011).
 */
final class BrowserPaymentRequestTest extends TestCase
{
    public function test_to_array_returns_documented_keys(): void
    {
        $request = new BrowserPaymentRequest(
            storeId: 'store-1',
            channelKey: 'channel-1',
            paymentId: 'payment-1',
            orderName: 'Order A',
            totalAmount: 10000,
            redirectUrl: 'https://example.com/payment-redirect',
            customerId: 'customer-1',
            payMethod: 'CARD',
            currency: 'KRW',
            forceRedirect: true,
            windowType: ['pc' => 'IFRAME', 'mobile' => 'REDIRECTION'],
        );

        $this->assertSame(
            [
                'storeId' => 'store-1',
                'channelKey' => 'channel-1',
                'paymentId' => 'payment-1',
                'orderName' => 'Order A',
                'totalAmount' => 10000,
                'redirectUrl' => 'https://example.com/payment-redirect',
                'customer' => ['customerId' => 'customer-1'],
                'payMethod' => 'CARD',
                'currency' => 'KRW',
                'forceRedirect' => true,
                'windowType' => ['pc' => 'IFRAME', 'mobile' => 'REDIRECTION'],
            ],
            $request->toArray(),
        );
    }

    public function test_unset_optional_values_are_omitted(): void
    {
        $request = new BrowserPaymentRequest(
            storeId: 'store-1',
            channelKey: 'channel-1',
            paymentId: 'payment-1',
            orderName: 'Order A',
            totalAmount: 100,
            redirectUrl: 'http://192.168.0.2:3000/payment-redirect',
        );

        $this->assertSame(
            [
                'storeId' => 'store-1',
                'channelKey' => 'channel-1',
                'paymentId' => 'payment-1',
                'orderName' => 'Order A',
                'totalAmount' => 100,
                'redirectUrl' => 'http://192.168.0.2:3000/payment-redirect',
            ],
            $request->toArray(),
        );
    }

    public function test_non_absolute_http_redirect_url_throws(): void
    {
        $invalid = ['', 'payment-redirect', '/payment-redirect', 'ftp://example.com/redirect'];

        foreach ($invalid as $redirectUrl) {
            try {
                new BrowserPaymentRequest(
                    storeId: 'store-1',
                    channelKey: 'channel-1',
                    paymentId: 'payment-1',
                    orderName: 'Order A',
                    totalAmount: 100,
                    redirectUrl: $redirectUrl,
                );
                self::fail('Expected an invalid redirectUrl to be rejected.');
            } catch (\InvalidArgumentException) {
                self::assertTrue(true);
            }
        }
    }

    public function test_extra_keys_are_added_and_documented_values_win(): void
    {
        $request = new BrowserPaymentRequest(
            storeId: 'store-1',
            channelKey: 'channel-1',
            paymentId: 'payment-1',
            orderName: 'Order A',
            totalAmount: 100,
            redirectUrl: 'https://example.com/payment-redirect',
            extra: [
                'bypass' => ['kcp_v2' => ['site_name' => 'Shop']],
                'totalAmount' => 999,
            ],
        );

        $this->assertSame(
            [
                'storeId' => 'store-1',
                'channelKey' => 'channel-1',
                'paymentId' => 'payment-1',
                'orderName' => 'Order A',
                'totalAmount' => 100,
                'redirectUrl' => 'https://example.com/payment-redirect',
                'bypass' => ['kcp_v2' => ['site_name' => 'Shop']],
            ],
            $request->toArray(),
        );
    }
}
