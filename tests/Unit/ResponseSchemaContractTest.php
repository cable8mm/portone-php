<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use PHPUnit\Framework\TestCase;

final class ResponseSchemaContractTest extends TestCase
{
    public function test_recorded_jvm_schema_contains_response_fields_and_types(): void
    {
        $schema = json_decode(
            (string) file_get_contents(__DIR__.'/../fixtures/jvm-v0.24.0-response-schema.json'),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );

        self::assertSame('jvm-v0.24.0', $schema['reference']['tag']);
        self::assertSame(
            ['items' => 'List<Payment>', 'page' => 'PageInfo'],
            $schema['models']['GetPaymentsResponse']['fields'],
        );
        self::assertSame(
            ['accessToken' => 'String', 'refreshToken' => 'String'],
            $schema['models']['LoginViaApiSecretResponse']['fields'],
        );
    }

    public function test_php_response_classes_can_be_detected_as_typed_or_raw_data(): void
    {
        $payments = (string) file_get_contents(__DIR__.'/../../src/Response/GetPaymentsResponse.php');
        $login = (string) file_get_contents(__DIR__.'/../../src/Response/LoginViaApiSecretResponse.php');

        self::assertStringContainsString('public readonly array $items', $payments);
        self::assertStringContainsString('public readonly array $page', $payments);
        self::assertStringNotContainsString('extends OperationResponse', $payments);
        self::assertStringContainsString('extends OperationResponse', $login);
    }
}
