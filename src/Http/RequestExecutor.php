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

    public function __construct(private readonly string $apiSecret)
    {
        if ($apiSecret === '') {
            throw new \InvalidArgumentException('apiSecret must not be empty.');
        }

        $this->client = $this->createClient();
    }

    /** @param array<string,mixed> $options */
    public function request(string $method, string $uri, array $options = []): ResponseInterface
    {
        try {
            return $this->client->request($method, $uri, $this->options($options));
        } catch (GuzzleException $exception) {
            throw new TransportException('PortOne request failed.', previous: $exception);
        }
    }

    /** @param array<string,mixed> $options */
    public function requestAsync(string $method, string $uri, array $options = []): PromiseInterface
    {
        return $this->client->requestAsync($method, $uri, $this->options($options))->then(
            static fn (ResponseInterface $response): ResponseInterface => $response,
            static function (\Throwable $exception): never {
                throw new TransportException('PortOne request failed.', previous: $exception);
            },
        );
    }

    /** @param array<string,mixed> $options */
    private function options(array $options): array
    {
        $headers = $options['headers'] ?? [];
        $headers['Authorization'] = 'PortOne '.$this->apiSecret;
        $headers['Accept'] ??= 'application/json';

        return $options + [
            'connect_timeout' => self::CONNECT_TIMEOUT,
            'timeout' => self::TOTAL_TIMEOUT,
            'http_errors' => false,
            'headers' => $headers,
        ];
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
