<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

use Cable8mm\PortonePhp\Exception\InvalidRequestException;
use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\Exception\UnauthorizedException;
use Cable8mm\PortonePhp\Exception\UnknownException;
use Cable8mm\PortonePhp\Exception\UnrecognizedResponseException;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\Response\GetPaymentsResponse;
use Psr\Http\Message\ResponseInterface;

class PaymentClient
{
    private readonly RequestExecutor $executor;

    public function __construct(string $apiSecret)
    {
        $this->executor = $this->createExecutor($apiSecret);
    }

    /** @param array<string,mixed>|null $page @param array<string,mixed>|null $filter */
    public function getPayments(?array $page = null, ?array $filter = null): GetPaymentsResponse
    {
        return $this->interpret(
            $this->executor->request('GET', '/payments', $this->requestOptions($page, $filter)),
        );
    }

    /** @param array<string,mixed>|null $page @param array<string,mixed>|null $filter */
    public function getPaymentsAsync(?array $page = null, ?array $filter = null): Future
    {
        $promise = $this->executor->requestAsync(
            'GET',
            '/payments',
            $this->requestOptions($page, $filter),
        )->then(fn (ResponseInterface $response): GetPaymentsResponse => $this->interpret($response));

        return new Future($promise);
    }

    /** @param array<string,mixed>|null $page @param array<string,mixed>|null $filter */
    private function requestOptions(?array $page, ?array $filter): array
    {
        $requestBody = [];
        if ($page !== null) {
            $requestBody['page'] = $page;
        }
        if ($filter !== null) {
            $requestBody['filter'] = $filter;
        }

        return [
            'query' => [
                'requestBody' => json_encode($requestBody, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES),
            ],
        ];
    }

    private function interpret(ResponseInterface $response): GetPaymentsResponse
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();

        if ($status < 200 || $status >= 300) {
            $decoded = json_decode($body, true);
            $type = is_array($decoded) && is_string($decoded['type'] ?? null) ? $decoded['type'] : null;
            $message = is_array($decoded) && is_string($decoded['message'] ?? null)
                ? $decoded['message']
                : 'PortOne returned an error response.';

            if ($type === 'INVALID_REQUEST') {
                throw new InvalidRequestException($message, $status, $body);
            }
            if ($type === 'UNAUTHORIZED') {
                throw new UnauthorizedException($message, $status, $body);
            }

            throw new UnknownException('getPayments', $message, $status, $body);
        }

        try {
            $decoded = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
            if (! is_array($decoded)) {
                throw new \UnexpectedValueException('Expected a JSON object.');
            }

            return GetPaymentsResponse::fromArray($decoded);
        } catch (\Throwable $exception) {
            if ($exception instanceof PortOneException) {
                throw $exception;
            }

            throw new UnrecognizedResponseException(
                'PortOne returned an undecodable success response.',
                $status,
                $body,
                $exception,
            );
        }
    }

    protected function createExecutor(string $apiSecret): RequestExecutor
    {
        return new RequestExecutor($apiSecret);
    }
}
