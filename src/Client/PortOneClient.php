<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Http\RequestExecutor;

/**
 * PortOne V2 API의 기능별 클라이언트를 제공하는 최상위 클라이언트입니다.
 */
final class PortOneClient extends AbstractClient
{
    public readonly PaymentClient $payment;

    public readonly IdentityVerificationClient $identityVerification;

    public readonly PgSpecificClient $pgSpecific;

    public readonly AuthClient $auth;

    public readonly ReconciliationClient $reconciliation;

    public readonly PlatformClient $platform;

    public readonly B2bClient $b2b;

    public readonly CommonClient $common;

    public readonly CheckoutClient $checkout;

    public readonly PaymentSessionClient $paymentSession;

    /**
     * PortOneClient 객체를 초기화합니다.
     */
    public function __construct(#[\SensitiveParameter] string $apiSecret, ?RequestExecutor $executor = null)
    {
        parent::__construct($apiSecret, $executor);
        $this->payment = new PaymentClient('', $this->executor);
        $this->identityVerification = new IdentityVerificationClient('', $this->executor);
        $this->pgSpecific = new PgSpecificClient('', $this->executor);
        $this->auth = new AuthClient('', $this->executor);
        $this->reconciliation = new ReconciliationClient('', $this->executor);
        $this->platform = new PlatformClient('', $this->executor);
        $this->b2b = new B2bClient('', $this->executor);
        $this->common = new CommonClient('', $this->executor);
        $this->checkout = new CheckoutClient('', $this->executor);
        $this->paymentSession = new PaymentSessionClient('', $this->executor);
    }
}
