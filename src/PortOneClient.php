<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

use Cable8mm\PortonePhp\Http\RequestExecutor;

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

    public function __construct(string $apiSecret, ?RequestExecutor $executor = null)
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
