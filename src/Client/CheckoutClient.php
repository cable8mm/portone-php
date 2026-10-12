<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Model;

final class CheckoutClient extends AbstractClient
{
    public function evaluateCheckoutProfile(?string $profileKey = null, ?string $country = null, ?string $currency = null, ?int $amount = null): Model\EvaluateCheckoutProfileResponse
    {
        return $this->callOperation('evaluateCheckoutProfile', 'GET', '/checkout-profiles/evaluate', ['profileKey' => $profileKey, 'country' => $country, 'currency' => $currency, 'amount' => $amount], Model\EvaluateCheckoutProfileResponse::class, false);
    }

    public function evaluateCheckoutProfileAsync(?string $profileKey = null, ?string $country = null, ?string $currency = null, ?int $amount = null): Future
    {
        return $this->callOperationAsync('evaluateCheckoutProfile', 'GET', '/checkout-profiles/evaluate', ['profileKey' => $profileKey, 'country' => $country, 'currency' => $currency, 'amount' => $amount], Model\EvaluateCheckoutProfileResponse::class, false);
    }
}
