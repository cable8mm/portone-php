<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

use Cable8mm\PortonePhp\Http\RequestExecutor;

final class B2bClient extends AbstractClient
{
    public readonly TaxInvoiceClient $taxInvoice;

    public readonly CounterpartyClient $counterparty;

    public function __construct(string $apiSecret, ?RequestExecutor $executor = null)
    {
        parent::__construct($apiSecret, $executor);
        $this->taxInvoice = new TaxInvoiceClient('', $this->executor);
        $this->counterparty = new CounterpartyClient('', $this->executor);
    }
}
