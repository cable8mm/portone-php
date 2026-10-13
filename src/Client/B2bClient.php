<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Http\RequestExecutor;

/**
 * B2B API 작업과 B2B 하위 클라이언트에 접근할 수 있습니다.
 */
final class B2bClient extends AbstractClient
{
    public readonly TaxInvoiceClient $taxInvoice;

    public readonly CounterpartyClient $counterparty;

    /**
     * B2bClient 객체를 초기화합니다.
     */
    public function __construct(#[\SensitiveParameter] string $apiSecret, ?RequestExecutor $executor = null)
    {
        parent::__construct($apiSecret, $executor);
        $this->taxInvoice = new TaxInvoiceClient('', $this->executor);
        $this->counterparty = new CounterpartyClient('', $this->executor);
    }
}
