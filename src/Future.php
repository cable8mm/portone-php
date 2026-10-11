<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

use GuzzleHttp\Promise\PromiseInterface;

/** @template T */
final class Future
{
    /** @param PromiseInterface<T> $promise */
    public function __construct(private readonly PromiseInterface $promise) {}

    public function isComplete(): bool
    {
        return $this->promise->getState() !== PromiseInterface::PENDING;
    }

    /** @return T */
    public function wait(): mixed
    {
        return $this->promise->wait();
    }
}
