<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Client;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Exception\ForbiddenException;
use Cable8mm\PortonePhp\Exception\InvalidRequestException;
use Cable8mm\PortonePhp\Exception\PlatformNotEnabledException;
use Cable8mm\PortonePhp\Exception\PortOneException;
use Cable8mm\PortonePhp\Exception\UnauthorizedException;
use Cable8mm\PortonePhp\Exception\UnknownException;
use Cable8mm\PortonePhp\Exception\UnrecognizedResponseException;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Psr\Http\Message\ResponseInterface;

/**
 * PortOne API 클라이언트가 공유하는 요청 실행 기능을 제공합니다.
 */
abstract class AbstractClient
{
    protected readonly RequestExecutor $executor;

    /**
     * PortOne API Secret과 선택적으로 전달된 공용 요청 실행기로 클라이언트를 초기화합니다.
     *
     * @param  string  $apiSecret  PortOne V2 API 요청 인증에 사용하는 API Secret입니다.
     * @param  RequestExecutor|null  $executor  부모 클라이언트와 공유하는 요청 실행기입니다.
     */
    public function __construct(#[\SensitiveParameter] string $apiSecret, ?RequestExecutor $executor = null)
    {
        $this->executor = $executor ?? $this->createExecutor($apiSecret);
    }

    /**
     * 인증 정보가 디버그 출력에 노출되지 않도록 빈 정보를 반환합니다.
     */
    public function __debugInfo(): array
    {
        $properties = get_object_vars($this);
        unset($properties['executor']);

        return $properties;
    }

    /**
     * 인증 정보가 직렬화되어 노출되지 않도록 직렬화를 거부합니다.
     */
    public function __serialize(): array
    {
        throw new \LogicException('Client instances cannot be serialized.');
    }

    /**
     * 인증 정보가 포함된 객체의 역직렬화를 거부합니다.
     */
    public function __unserialize(#[\SensitiveParameter] array $data): void
    {
        throw new \LogicException('Client instances cannot be unserialized.');
    }

    protected function createExecutor(#[\SensitiveParameter] string $apiSecret): RequestExecutor
    {
        return new RequestExecutor($apiSecret);
    }

    /**
     * @param  array<string,mixed>  $parameters
     * @param  class-string<object>  $responseClass
     */
    protected function callOperation(
        string $operation,
        string $method,
        string $path,
        #[\SensitiveParameter] array $parameters,
        string $responseClass,
        bool $requestBody,
    ): object {
        return $this->interpretOperation(
            $operation,
            $this->executor->request($method, $this->path($path, $parameters), $this->options($method, $parameters, $path, $requestBody)),
            $responseClass,
        );
    }

    /**
     * @param  array<string,mixed>  $parameters
     * @param  class-string<object>  $responseClass
     */
    protected function callOperationAsync(
        string $operation,
        string $method,
        string $path,
        #[\SensitiveParameter] array $parameters,
        string $responseClass,
        bool $requestBody,
    ): Future {
        $promise = $this->executor->requestAsync(
            $method,
            $this->path($path, $parameters),
            $this->options($method, $parameters, $path, $requestBody),
        );

        return new Future(
            $promise,
            fn (ResponseInterface $response): object => $this->interpretOperation($operation, $response, $responseClass),
        );
    }

    /**
     * @param  array<string,mixed>  $query
     * @param  array<string,mixed>  $body
     * @param  class-string<object>  $responseClass
     */
    protected function callOperationWithQueryAndBody(
        string $operation,
        string $method,
        string $path,
        array $query,
        array $body,
        string $responseClass,
    ): object {
        return $this->interpretOperation(
            $operation,
            $this->executor->request($method, $this->path($path, $query), $this->optionsWithQueryAndBody($query, $body)),
            $responseClass,
        );
    }

    /**
     * @param  array<string,mixed>  $query
     * @param  array<string,mixed>  $body
     * @param  class-string<object>  $responseClass
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
        );

        return new Future(
            $promise,
            fn (ResponseInterface $response): object => $this->interpretOperation($operation, $response, $responseClass),
        );
    }

    /**
     * @param  array<string,mixed>  $query
     * @param  array<string,mixed>  $body
     * @param  class-string<object>  $responseClass
     */
    protected function callOperationWithQueryRequestBody(
        string $operation,
        string $method,
        string $path,
        array $query,
        array $body,
        string $responseClass,
    ): object {
        return $this->interpretOperation(
            $operation,
            $this->executor->request($method, $this->path($path, $query), $this->optionsWithQueryRequestBody($query, $body)),
            $responseClass,
        );
    }

    /**
     * @param  array<string,mixed>  $query
     * @param  array<string,mixed>  $body
     * @param  class-string<object>  $responseClass
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
        );

        return new Future(
            $promise,
            fn (ResponseInterface $response): object => $this->interpretOperation($operation, $response, $responseClass),
        );
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
        $promise = $this->executor->requestAsync($method, $path, $options);

        return new Future($promise, function (ResponseInterface $response) use ($operation): string {
            if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
                $this->throwForError($operation, $response);
            }

            return (string) $response->getBody();
        });
    }

    /**
     * @param  array<string, mixed>  $query
     * @param  array<string, mixed>  $body
     */
    protected function callStringOperationWithQueryRequestBody(string $operation, string $method, string $path, array $query, array $body): string
    {
        return $this->callStringOperation($operation, $method, $this->path($path, $query), $this->optionsWithQueryRequestBody($query, $body));
    }

    /**
     * @param  array<string, mixed>  $query
     * @param  array<string, mixed>  $body
     */
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
        $promise = $this->executor->requestAsync($method, $path, $options);

        return new Future($promise, function (ResponseInterface $response) use ($operation): mixed {
            if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
                $this->throwForError($operation, $response);
            }

            return null;
        });
    }

    /**
     * @param  array<string, mixed>  $query
     * @param  array<string, mixed>  $body
     */
    protected function callUnitOperationWithQueryAndBody(string $operation, string $method, string $path, array $query, array $body): void
    {
        $this->callUnitOperation($operation, $method, $this->path($path, $query), $this->optionsWithQueryAndBody($query, $body));
    }

    /**
     * @param  array<string, mixed>  $query
     * @param  array<string, mixed>  $body
     */
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
    private function options(
        string $method,
        #[\SensitiveParameter] array $parameters,
        string $path,
        bool $requestBody,
    ): array {
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

    /** @param class-string<object> $responseClass */
    private function interpretOperation(string $operation, ResponseInterface $response, string $responseClass): object
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
