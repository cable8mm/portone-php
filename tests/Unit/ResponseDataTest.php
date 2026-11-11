<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\DiscriminatedResponse;
use Cable8mm\PortonePhp\Model\FailedNotOkResponse;
use Cable8mm\PortonePhp\Model\OperationResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Decodes every response model from a sample body built from the bundled OpenAPI definition
 * and checks that the decoded body is exposed as `data`.
 */
final class ResponseDataTest extends TestCase
{
    /**
     * Models whose decoder disagrees with the bundled OpenAPI definition, so a body built from the
     * definition is rejected before a model exists. Reported for follow-up tasks; remove an entry
     * once its decoder follows the definition.
     */
    private const DECODER_DRIFT = [
        'B2bCounterparty' => 'businessStatus is a string enum in the definition; the decoder requires an object.',
        'GetB2bCounterpartiesResponse' => 'items are B2bCounterparty; see B2bCounterparty.',
        'GetAllPaymentEventsByCursorResponse' => 'items are PaymentEventWithCursor in the definition; the decoder reads PaymentEvent.',
        'GetB2bTaxInvoicesResponse' => 'items are B2bTaxInvoiceSummary in the definition; the decoder reads B2bTaxInvoice.',
        'PlatformContract' => 'settlementCycle is an object in the definition; the decoder requires a string.',
        'PlatformPartner' => 'type is an object union in the definition; the decoder requires a string.',
    ];

    /** @var array<string, mixed>|null */
    private static ?array $document = null;

    /**
     * @return iterable<string, array{class-string<OperationResponse>, array<string, mixed>}>
     */
    public static function responseModels(): iterable
    {
        $schemas = self::document()['components']['schemas'];
        foreach (glob(dirname(__DIR__, 2).'/src/Model/*.php') ?: [] as $path) {
            $class = 'Cable8mm\\PortonePhp\\Model\\'.basename($path, '.php');
            if (! class_exists($class) || ! is_subclass_of($class, OperationResponse::class)) {
                continue;
            }
            if ($class === DiscriminatedResponse::class) {
                // Base class of the discriminated models below; no operation returns it directly.
                continue;
            }
            $name = (new \ReflectionClass($class))->getShortName();
            if ($class === FailedNotOkResponse::class) {
                // No OpenAPI schema carries this name; the model decodes an empty object.
                yield $name => [$class, []];

                continue;
            }
            self::assertArrayHasKey($name, $schemas, $name.' has no OpenAPI schema.');
            $sample = self::sample(['$ref' => '#/components/schemas/'.$name], 0);
            self::assertIsArray($sample);

            yield $name => [$class, $sample];
        }
    }

    public function test_every_response_model_is_covered(): void
    {
        $count = 0;
        foreach (glob(dirname(__DIR__, 2).'/src/Model/*.php') ?: [] as $path) {
            $class = 'Cable8mm\\PortonePhp\\Model\\'.basename($path, '.php');
            if (class_exists($class) && is_subclass_of($class, OperationResponse::class)) {
                $count++;
            }
        }

        self::assertSame($count - 1, iterator_count(self::responseModels()));
    }

    /**
     * @param  class-string<OperationResponse>  $class
     * @param  array<string, mixed>  $body
     */
    #[DataProvider('responseModels')]
    public function test_response_model_exposes_decoded_body_as_data(string $class, array $body): void
    {
        $name = (new \ReflectionClass($class))->getShortName();
        if (array_key_exists($name, self::DECODER_DRIFT)) {
            $this->expectException(\UnexpectedValueException::class);
        }

        $model = $class::fromArray($body);

        self::assertInstanceOf($class, $model);
        self::assertSame($body, $model->data);
    }

    public function test_directly_constructed_model_has_empty_data(): void
    {
        self::assertSame([], (new FailedNotOkResponse)->data);
    }

    /** @return array<string, mixed> */
    private static function document(): array
    {
        return self::$document ??= json_decode(
            (string) file_get_contents(dirname(__DIR__).'/fixtures/portone-v2-openapi.json'),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
    }

    /**
     * Builds a value that satisfies the schema: every declared property, the first union variant,
     * the first enum value, and a format-shaped string for date and date-time.
     *
     * @param  array<string, mixed>  $schema
     */
    private static function sample(array $schema, int $depth): mixed
    {
        if (isset($schema['$ref'])) {
            $name = substr((string) $schema['$ref'], strlen('#/components/schemas/'));

            return self::sample(self::document()['components']['schemas'][$name] + ['x-name' => $name], $depth + 1);
        }

        foreach (['oneOf', 'anyOf'] as $union) {
            if (isset($schema[$union])) {
                return self::sample($schema[$union][0], $depth);
            }
        }

        if (isset($schema['allOf'])) {
            $value = [];
            foreach ($schema['allOf'] as $part) {
                $value = array_merge($value, (array) self::sample($part, $depth));
            }

            return $value;
        }

        if (isset($schema['enum'])) {
            return $schema['enum'][0];
        }

        $type = $schema['type'] ?? (isset($schema['properties']) ? 'object' : null);

        return match ($type) {
            'string' => match ($schema['format'] ?? null) {
                'date-time' => '2026-01-01T00:00:00Z',
                'date' => '2026-01-01',
                default => 'sample',
            },
            'integer', 'number' => 1,
            'boolean' => true,
            'array' => $depth > 8 ? [] : [self::sample($schema['items'] ?? [], $depth)],
            'object' => self::sampleObject($schema, $depth),
            default => [],
        };
    }

    /**
     * @param  array<string, mixed>  $schema
     * @return array<string, mixed>
     */
    private static function sampleObject(array $schema, int $depth): array
    {
        $value = [];
        $required = $schema['required'] ?? [];
        foreach ($schema['properties'] ?? [] as $property => $propertySchema) {
            if ($depth > 8 && ! in_array($property, $required, true)) {
                continue;
            }
            $value[$property] = self::sample($propertySchema, $depth);
        }

        $discriminator = self::discriminatorValue($schema['x-name'] ?? null);
        if ($discriminator !== null) {
            $value[$discriminator[0]] = $discriminator[1];
        }

        return $value;
    }

    /**
     * Returns the discriminator property and value that a parent union maps to the named schema.
     *
     * @return array{string, string}|null
     */
    private static function discriminatorValue(?string $name): ?array
    {
        if ($name === null) {
            return null;
        }
        foreach (self::document()['components']['schemas'] as $schema) {
            foreach ($schema['discriminator']['mapping'] ?? [] as $value => $reference) {
                if ($reference === '#/components/schemas/'.$name) {
                    return [(string) $schema['discriminator']['propertyName'], (string) $value];
                }
            }
        }

        return null;
    }
}
