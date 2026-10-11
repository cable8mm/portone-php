<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp;

use Cable8mm\PortonePhp\Exception\ForbiddenException;
use Cable8mm\PortonePhp\Exception\InvalidRequestException;
use Cable8mm\PortonePhp\Exception\PlatformNotEnabledException;
use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\Exception\UnauthorizedException;
use Cable8mm\PortonePhp\Exception\UnknownException;
use Cable8mm\PortonePhp\Exception\UnrecognizedResponseException;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Psr\Http\Message\ResponseInterface;

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

    /**
     * @param  array<string,mixed>  $parameters
     * @param  class-string<Response\OperationResponse>  $responseClass
     */
    protected function callOperation(
        string $operation,
        string $method,
        string $path,
        array $parameters,
        string $responseClass,
        bool $requestBody,
    ): Response\OperationResponse {
        return $this->interpretOperation(
            $operation,
            $this->executor->request($method, $this->path($path, $parameters), $this->options($method, $parameters, $path, $requestBody)),
            $responseClass,
        );
    }

    /**
     * @param  array<string,mixed>  $parameters
     * @param  class-string<Response\OperationResponse>  $responseClass
     */
    protected function callOperationAsync(
        string $operation,
        string $method,
        string $path,
        array $parameters,
        string $responseClass,
        bool $requestBody,
    ): Future {
        $promise = $this->executor->requestAsync(
            $method,
            $this->path($path, $parameters),
            $this->options($method, $parameters, $path, $requestBody),
        )->then(fn (ResponseInterface $response): Response\OperationResponse => $this->interpretOperation($operation, $response, $responseClass));

        return new Future($promise);
    }

    /**
     * @param  array<string,mixed>  $query
     * @param  array<string,mixed>  $body
     * @param  class-string<Response\OperationResponse>  $responseClass
     */
    protected function callOperationWithQueryAndBody(
        string $operation,
        string $method,
        string $path,
        array $query,
        array $body,
        string $responseClass,
    ): Response\OperationResponse {
        return $this->interpretOperation(
            $operation,
            $this->executor->request($method, $this->path($path, $query), $this->optionsWithQueryAndBody($query, $body)),
            $responseClass,
        );
    }

    /**
     * @param  array<string,mixed>  $query
     * @param  array<string,mixed>  $body
     * @param  class-string<Response\OperationResponse>  $responseClass
     */
    protected function callOperationWithQueryAndBodyAsync(
        string $operation,
        string $method,
        string $path,
        array $query,
        array $body,
        string $responseClass,
    ): Future {
        $promise = $this->executor->requestAsync(
            $method,
            $this->path($path, $query),
            $this->optionsWithQueryAndBody($query, $body),
        )->then(fn (ResponseInterface $response): Response\OperationResponse => $this->interpretOperation($operation, $response, $responseClass));

        return new Future($promise);
    }

    /**
     * @param  array<string,mixed>  $query
     * @param  array<string,mixed>  $body
     * @param  class-string<Response\OperationResponse>  $responseClass
     */
    protected function callOperationWithQueryRequestBody(
        string $operation,
        string $method,
        string $path,
        array $query,
        array $body,
        string $responseClass,
    ): Response\OperationResponse {
        return $this->interpretOperation(
            $operation,
            $this->executor->request($method, $this->path($path, $query), $this->optionsWithQueryRequestBody($query, $body)),
            $responseClass,
        );
    }

    /**
     * @param  array<string,mixed>  $query
     * @param  array<string,mixed>  $body
     * @param  class-string<Response\OperationResponse>  $responseClass
     */
    protected function callOperationWithQueryRequestBodyAsync(
        string $operation,
        string $method,
        string $path,
        array $query,
        array $body,
        string $responseClass,
    ): Future {
        $promise = $this->executor->requestAsync(
            $method,
            $this->path($path, $query),
            $this->optionsWithQueryRequestBody($query, $body),
        )->then(fn (ResponseInterface $response): Response\OperationResponse => $this->interpretOperation($operation, $response, $responseClass));

        return new Future($promise);
    }

    /** @param array<string,mixed> $options */
    protected function callStringOperation(string $operation, string $method, string $path, array $options = []): string
    {
        $response = $this->executor->request($method, $path, $options);
        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            $this->throwForError($operation, $response);
        }

        return (string) $response->getBody();
    }

    /** @param array<string,mixed> $options */
    protected function callStringOperationAsync(string $operation, string $method, string $path, array $options = []): Future
    {
        $promise = $this->executor->requestAsync($method, $path, $options)->then(function (ResponseInterface $response) use ($operation): string {
            if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
                $this->throwForError($operation, $response);
            }

            return (string) $response->getBody();
        });

        return new Future($promise);
    }

    /** @param array<string,mixed> $query @param array<string,mixed> $body */
    protected function callStringOperationWithQueryRequestBody(string $operation, string $method, string $path, array $query, array $body): string
    {
        return $this->callStringOperation($operation, $method, $this->path($path, $query), $this->optionsWithQueryRequestBody($query, $body));
    }

    /** @param array<string,mixed> $query @param array<string,mixed> $body */
    protected function callStringOperationWithQueryRequestBodyAsync(string $operation, string $method, string $path, array $query, array $body): Future
    {
        return $this->callStringOperationAsync($operation, $method, $this->path($path, $query), $this->optionsWithQueryRequestBody($query, $body));
    }

    /** @param array<string,mixed> $options */
    protected function callUnitOperation(string $operation, string $method, string $path, array $options = []): void
    {
        $this->callStringOperation($operation, $method, $path, $options);
    }

    /** @param array<string,mixed> $options */
    protected function callUnitOperationAsync(string $operation, string $method, string $path, array $options = []): Future
    {
        $promise = $this->executor->requestAsync($method, $path, $options)->then(function (ResponseInterface $response) use ($operation): mixed {
            if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
                $this->throwForError($operation, $response);
            }

            return null;
        });

        return new Future($promise);
    }

    /** @param array<string,mixed> $query @param array<string,mixed> $body */
    protected function callUnitOperationWithQueryAndBody(string $operation, string $method, string $path, array $query, array $body): void
    {
        $this->callUnitOperation($operation, $method, $this->path($path, $query), $this->optionsWithQueryAndBody($query, $body));
    }

    /** @param array<string,mixed> $query @param array<string,mixed> $body */
    protected function callUnitOperationWithQueryAndBodyAsync(string $operation, string $method, string $path, array $query, array $body): Future
    {
        return $this->callUnitOperationAsync($operation, $method, $this->path($path, $query), $this->optionsWithQueryAndBody($query, $body));
    }

    /** @param array<string,mixed> $query */
    protected function callUnitOperationWithQuery(string $operation, string $method, string $path, array $query): void
    {
        $this->callUnitOperation($operation, $method, $this->path($path, $query), ['query' => array_filter($query, static fn (mixed $value): bool => $value !== null)]);
    }

    /** @param array<string,mixed> $query */
    protected function callUnitOperationWithQueryAsync(string $operation, string $method, string $path, array $query): Future
    {
        return $this->callUnitOperationAsync($operation, $method, $this->path($path, $query), ['query' => array_filter($query, static fn (mixed $value): bool => $value !== null)]);
    }

    /** @param array<string,mixed> $parameters */
    private function path(string $path, array &$parameters): string
    {
        return (string) preg_replace_callback('/\\{([A-Za-z][A-Za-z0-9]*)\\}/', static function (array $match) use (&$parameters): string {
            $name = $match[1];
            $value = $parameters[$name] ?? '';
            unset($parameters[$name]);

            return rawurlencode((string) $value);
        }, $path);
    }

    /** @param array<string,mixed> $parameters */
    private function options(string $method, array $parameters, string $path, bool $requestBody): array
    {
        $parameters = array_filter($parameters, static fn (mixed $value): bool => $value !== null);

        if ($requestBody) {
            if ($method !== 'GET') {
                return ['json' => $parameters];
            }

            return [
                'query' => [
                    'requestBody' => json_encode($parameters, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES),
                ],
            ];
        }

        return ['query' => $parameters];
    }

    /**
     * @param  array<string,mixed>  $query
     * @param  array<string,mixed>  $body
     * @return array<string,mixed>
     */
    private function optionsWithQueryAndBody(array &$query, array $body): array
    {
        $query = array_filter($query, static fn (mixed $value): bool => $value !== null);
        $body = array_filter($body, static fn (mixed $value): bool => $value !== null);

        $options = [];
        if ($query !== []) {
            $options['query'] = $query;
        }
        if ($body !== []) {
            $options['json'] = $body;
        }

        return $options;
    }

    /**
     * @param  array<string,mixed>  $query
     * @param  array<string,mixed>  $body
     * @return array<string,mixed>
     */
    private function optionsWithQueryRequestBody(array &$query, array $body): array
    {
        $query = array_filter($query, static fn (mixed $value): bool => $value !== null);
        $body = array_filter($body, static fn (mixed $value): bool => $value !== null);

        return [
            'query' => $query + [
                'requestBody' => json_encode($body, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES),
            ],
        ];
    }

    /** @param class-string<Response\OperationResponse> $responseClass */
    private function interpretOperation(string $operation, ResponseInterface $response, string $responseClass): Response\OperationResponse
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();

        if ($status < 200 || $status >= 300) {
            $this->throwForError($operation, $response);
        }

        try {
            $decoded = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
            if (! is_array($decoded)) {
                throw new \UnexpectedValueException('Expected a JSON object.');
            }

            return $responseClass::fromArray($decoded);
        } catch (PortOneException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            throw new UnrecognizedResponseException(
                'PortOne returned an undecodable success response.',
                $status,
                $body,
                $exception,
            );
        }
    }

    private function throwForError(string $operation, ResponseInterface $response): never
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        $decoded = json_decode($body, true);
        $message = is_array($decoded) && is_string($decoded['message'] ?? null)
            ? $decoded['message']
            : 'PortOne returned an error response.';

        $type = is_array($decoded) && is_string($decoded['type'] ?? null)
            ? $decoded['type']
            : null;
        if ($type === 'INVALID_REQUEST') {
            throw new InvalidRequestException($message, $status, $body, null, $type);
        }
        if ($type === 'FORBIDDEN') {
            throw new ForbiddenException($message, $status, $body, null, $type);
        }
        if ($type === 'PLATFORM_NOT_ENABLED') {
            throw new PlatformNotEnabledException($message, $status, $body, null, $type);
        }
        if ($type === 'UNAUTHORIZED') {
            throw new UnauthorizedException($message, $status, $body, null, $type);
        }

        throw new UnknownException($operation, $message, $status, $body, null, $type);
    }
}
