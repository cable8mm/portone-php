<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Async;

use Cable8mm\PortonePhp\Exception\TransportException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 비동기 PortOne API 요청의 완료 상태와 결과를 다루는 객체입니다.
 *
 * @template T
 */
final class Future
{
    private readonly ?\Closure $resolver;

    /**
     * 비동기 요청 Promise와 선택적 응답 변환기를 보관하는 Future를 생성합니다.
     *
     * @param  PromiseInterface<T>  $promise
     */
    public function __construct(
        private readonly PromiseInterface $promise,
        ?callable $resolver = null,
    ) {
        $this->resolver = $resolver === null ? null : \Closure::fromCallable($resolver);
    }

    /**
     * 비동기 요청이 완료되었는지 확인합니다.
     */
    public function isComplete(): bool
    {
        return $this->promise->getState() !== PromiseInterface::PENDING;
    }

    /**
     * 비동기 요청이 끝날 때까지 기다린 뒤 결과를 반환합니다. 요청 또는 응답 처리에 실패하면 해당 예외를 던집니다.
     *
     * @return T
     */
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
