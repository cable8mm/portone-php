<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Http;

use Cable8mm\PortonePhp\Exception\TransportException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

class RequestExecutor
{
    private const CONNECT_TIMEOUT = 10;

    private const TOTAL_TIMEOUT = 30;

    private readonly Client $client;

    private readonly \Closure $authorizationHeader;

    public function __construct(#[\SensitiveParameter] string $apiSecret)
    {
        if ($apiSecret === '') {
            throw new \InvalidArgumentException('apiSecret must not be empty.');
        }

        $this->authorizationHeader = static fn (): string => 'PortOne '.$apiSecret;
        $this->client = $this->createClient();
    }

    public function __debugInfo(): array
    {
        return [];
    }

    /** @param array<string,mixed> $options */
    public function request(
        string $method,
        string $uri,
        #[\SensitiveParameter] array $options = [],
    ): ResponseInterface {
        try {
            return $this->client->request($method, $uri, $this->options($options));
        } catch (GuzzleException) {
            throw new TransportException('PortOne request failed.');
        }
    }

    /** @param array<string,mixed> $options */
    public function requestAsync(
        string $method,
        string $uri,
        #[\SensitiveParameter] array $options = [],
    ): PromiseInterface {
        try {
            return $this->client->requestAsync($method, $uri, $this->options($options));
        } catch (GuzzleException) {
            throw new TransportException('PortOne request failed.');
        }
    }

    /** @param array<string,mixed> $options */
    private function options(#[\SensitiveParameter] array $options): array
    {
        if (isset($options['query']) && is_array($options['query'])) {
            $options['query'] = $this->normalizeQueryParameters($options['query']);
        }

        $headers = $options['headers'] ?? [];
        $headers['Authorization'] = ($this->authorizationHeader)();
        $headers['Accept'] ??= 'application/json';

        return $options + [
            'connect_timeout' => self::CONNECT_TIMEOUT,
            'timeout' => self::TOTAL_TIMEOUT,
            'http_errors' => false,
            'headers' => $headers,
        ];
    }

    /** @param array<string,mixed> $parameters @return array<string,mixed> */
    private function normalizeQueryParameters(array $parameters): array
    {
        foreach ($parameters as $key => $value) {
            if (is_bool($value)) {
                $parameters[$key] = $value ? 'true' : 'false';
            } elseif (is_array($value)) {
                $parameters[$key] = $this->normalizeQueryParameters($value);
            }
        }

        return $parameters;
    }

    protected function createClient(): Client
    {
        return new Client([
            'base_uri' => 'https://api.portone.io',
            'connect_timeout' => self::CONNECT_TIMEOUT,
            'timeout' => self::TOTAL_TIMEOUT,
            'http_errors' => false,
        ]);
    }
}
