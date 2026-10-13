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
     *
     * @param  string  $apiSecret  PortOne V2 API 요청 인증에 사용하는 API Secret입니다.
     * @param  RequestExecutor|null  $executor  부모 클라이언트와 공유하는 요청 실행기입니다.
     */
    public function __construct(#[\SensitiveParameter] string $apiSecret, ?RequestExecutor $executor = null)
    {
        parent::__construct($apiSecret, $executor);
        $this->taxInvoice = new TaxInvoiceClient('', $this->executor);
        $this->counterparty = new CounterpartyClient('', $this->executor);
    }
}
