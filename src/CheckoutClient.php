<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

final class CheckoutClient extends AbstractClient
{
    public function evaluateCheckoutProfile(mixed $profileKey = null, mixed $country = null, mixed $currency = null, mixed $amount = null): Response\EvaluateCheckoutProfileResponse
    {
        return $this->callOperation('evaluateCheckoutProfile', 'GET', '/checkout-profiles/evaluate', ['profileKey' => $profileKey, 'country' => $country, 'currency' => $currency, 'amount' => $amount], Response\EvaluateCheckoutProfileResponse::class, false);
    }

    public function evaluateCheckoutProfileAsync(mixed $profileKey = null, mixed $country = null, mixed $currency = null, mixed $amount = null): Future
    {
        return $this->callOperationAsync('evaluateCheckoutProfile', 'GET', '/checkout-profiles/evaluate', ['profileKey' => $profileKey, 'country' => $country, 'currency' => $currency, 'amount' => $amount], Response\EvaluateCheckoutProfileResponse::class, false);
    }
}
