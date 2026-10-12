<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Async\Future;
use Cable8mm\PortonePhp\Client\AbstractClient;
use Cable8mm\PortonePhp\Client\AuthClient;
use Cable8mm\PortonePhp\Client\PortOneClient;
use Cable8mm\PortonePhp\Exception\TransportException;
use Cable8mm\PortonePhp\Exception\UnauthorizedException;
use Cable8mm\PortonePhp\Http\RequestExecutor;
use Cable8mm\PortonePhp\Webhook\WebhookVerifier;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class SecretExposureTest extends TestCase
{
    public function test_client_and_verifier_debug_output_and_exports_hide_secrets(): void
    {
        $apiSecret = 'api-secret-that-must-not-leak';
        $clients = $this->clients(new PortOneClient($apiSecret));

        foreach ($clients as $client) {
            $this->assertSecretAbsentFromDiagnostics($apiSecret, $client);
        }

        $webhookSecret = 'webhook-secret-that-must-not-leak';
        $encodedWebhookSecret = base64_encode($webhookSecret);
        $verifier = new WebhookVerifier($encodedWebhookSecret);

        $this->assertSecretAbsentFromDiagnostics($webhookSecret, $verifier);
        $this->assertSecretAbsentFromDiagnostics($encodedWebhookSecret, $verifier);
    }

    public function test_clients_and_verifier_cannot_be_serialized_or_unserialized(): void
    {
        $objects = [
            ...$this->clients(new PortOneClient('serialization-api-secret')),
            new WebhookVerifier(base64_encode('serialization-webhook-secret')),
        ];

        foreach ($objects as $object) {
            try {
                serialize($object);
                self::fail($object::class.' was serialized.');
            } catch (\LogicException $exception) {
                self::assertStringNotContainsString('serialization-api-secret', $exception->getMessage());
                self::assertStringNotContainsString('serialization-webhook-secret', $exception->getMessage());
            }

            $class = $object::class;
            $payload = sprintf('O:%d:"%s":0:{}', strlen($class), $class);
            try {
                unserialize($payload);
                self::fail($class.' was unserialized.');
            } catch (\LogicException) {
                self::assertTrue(true);
            }
        }
    }

    public function test_invalid_webhook_secret_is_redacted_from_exception_diagnostics(): void
    {
        $secret = 'non-base64-webhook-secret-that-must-not-leak';
        $previousSetting = ini_get('zend.exception_ignore_args');
        ini_set('zend.exception_ignore_args', '0');

        try {
            new WebhookVerifier($secret);
            self::fail('The invalid webhook secret was accepted.');
        } catch (\InvalidArgumentException $exception) {
            $this->assertSecretAbsentFromDiagnostics($secret, $exception);
        } finally {
            if ($previousSetting !== false) {
                ini_set('zend.exception_ignore_args', $previousSetting);
            }
        }
    }

    public function test_auth_operation_secret_is_redacted_from_exception_diagnostics(): void
    {
        $clientSecret = 'client-api-secret-that-must-not-leak';
        $operationSecret = 'operation-api-secret-that-must-not-leak';
        $executor = new class($clientSecret) extends RequestExecutor
        {
            public function __construct(#[\SensitiveParameter] string $apiSecret)
            {
                parent::__construct($apiSecret);
            }

            protected function createClient(): Client
            {
                $failure = new Response(401, [], '{"type":"UNAUTHORIZED","message":"denied"}');

                return new Client([
                    'handler' => HandlerStack::create(new MockHandler([$failure, $failure])),
                    'http_errors' => false,
                ]);
            }
        };
        $client = new AuthClient($clientSecret, $executor);
        $previousSetting = ini_get('zend.exception_ignore_args');
        ini_set('zend.exception_ignore_args', '0');

        try {
            $client->loginViaApiSecret($operationSecret);
            self::fail('The authorization failure was not raised.');
        } catch (UnauthorizedException $exception) {
            $this->assertSecretAbsentFromDiagnostics($clientSecret, $exception);
            $this->assertSecretAbsentFromDiagnostics($operationSecret, $exception);
        } finally {
            if ($previousSetting !== false) {
                ini_set('zend.exception_ignore_args', $previousSetting);
            }
        }

        $previousSetting = ini_get('zend.exception_ignore_args');
        ini_set('zend.exception_ignore_args', '0');

        try {
            $client->loginViaApiSecretAsync($operationSecret)->wait();
            self::fail('The asynchronous authorization failure was not raised.');
        } catch (UnauthorizedException $exception) {
            $this->assertSecretAbsentFromDiagnostics($clientSecret, $exception);
            $this->assertSecretAbsentFromDiagnostics($operationSecret, $exception);
        } finally {
            if ($previousSetting !== false) {
                ini_set('zend.exception_ignore_args', $previousSetting);
            }
        }
    }

    public function test_transport_failures_do_not_retain_requests_containing_the_api_secret(): void
    {
        $apiSecret = 'transport-api-secret-that-must-not-leak';
        $failedRequest = new Request('GET', '/', ['Authorization' => 'PortOne '.$apiSecret]);
        $executor = new class($apiSecret, $failedRequest) extends RequestExecutor
        {
            public function __construct(
                #[\SensitiveParameter] string $apiSecret,
                private readonly Request $failedRequest,
            ) {
                parent::__construct($apiSecret);
            }

            protected function createClient(): Client
            {
                $failure = new ConnectException('Connection failed.', $this->failedRequest);

                return new Client([
                    'handler' => HandlerStack::create(new MockHandler([$failure, $failure])),
                    'http_errors' => false,
                ]);
            }
        };

        foreach ([
            fn (): mixed => $executor->request('GET', '/'),
            fn (): mixed => (new Future($executor->requestAsync('GET', '/')))->wait(),
        ] as $request) {
            try {
                $request();
                self::fail('The transport failure was not raised.');
            } catch (TransportException $exception) {
                self::assertNull($exception->getPrevious());
                $this->assertSecretAbsentFromDiagnostics($apiSecret, $exception);
            }
        }
    }

    /**
     * @return list<AbstractClient>
     */
    private function clients(AbstractClient $root): array
    {
        $clients = [];
        $visit = function (AbstractClient $client) use (&$visit, &$clients): void {
            $clients[] = $client;
            foreach (get_object_vars($client) as $property) {
                if ($property instanceof AbstractClient) {
                    $visit($property);
                }
            }
        };
        $visit($root);

        return $clients;
    }

    private function assertSecretAbsentFromDiagnostics(string $secret, object $value): void
    {
        ob_start();
        var_dump($value);
        $dump = (string) ob_get_clean();

        $diagnostics = [
            $dump,
            print_r($value, true),
            var_export($value, true),
        ];
        if ($value instanceof \Throwable) {
            $diagnostics[] = (string) $value;
        }

        foreach ($diagnostics as $diagnostic) {
            self::assertStringNotContainsString($secret, $diagnostic);
        }
    }
}
