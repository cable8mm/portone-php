<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Async;

use Cable8mm\PortonePhp\Exception\TransportException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

/** @template T */
final class Future
{
    private readonly ?\Closure $resolver;

    /** @param PromiseInterface<T> $promise */
    public function __construct(
        private readonly PromiseInterface $promise,
        ?callable $resolver = null,
    ) {
        $this->resolver = $resolver === null ? null : \Closure::fromCallable($resolver);
    }

    public function isComplete(): bool
    {
        return $this->promise->getState() !== PromiseInterface::PENDING;
    }

    /** @return T */
    public function wait(): mixed
    {
        try {
            $response = $this->promise->wait();
        } catch (\Throwable) {
            throw new TransportException('PortOne request failed.');
        }

        if ($this->resolver === null) {
            return $response;
        }

        if (! $response instanceof ResponseInterface) {
            throw new TransportException('PortOne request failed.');
        }

        return ($this->resolver)($response);
    }
}
