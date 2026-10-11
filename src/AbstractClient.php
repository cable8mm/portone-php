<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

use Cable8mm\PortonePhp\Http\RequestExecutor;

abstract class AbstractClient
{
    protected readonly RequestExecutor $executor;

    /**
     * The executor argument is internal and is used only when a parent shares
     * its already-created executor with a child client.
     */
    public function __construct(string $apiSecret, ?RequestExecutor $executor = null)
    {
        $this->executor = $executor ?? $this->createExecutor($apiSecret);
    }

    protected function createExecutor(string $apiSecret): RequestExecutor
    {
        return new RequestExecutor($apiSecret);
    }
}
