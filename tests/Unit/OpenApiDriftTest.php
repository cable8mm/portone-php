<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Tools\OpenApiDrift;
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__, 2).'/tools/OpenApiDrift.php';

final class OpenApiDriftTest extends TestCase
{
    public function test_unchanged_documents_have_no_drift(): void
    {
        $document = $this->document();
        $drift = OpenApiDrift::compare($document, $document);

        self::assertFalse(OpenApiDrift::hasDrift($drift));
        self::assertStringContainsString('No operation or schema drift detected.', OpenApiDrift::markdown($drift, '2026-10-12', '2026-10-13 00:00:00'));
    }

    public function test_operation_additions_removals_and_changes_are_reported(): void
    {
        $baseline = $this->document();
        $current = $baseline;
        unset($current['paths']['/payments/{paymentId}']['get']);
        $current['paths']['/payments/{paymentId}']['post'] = [
            'operationId' => 'cancelPayment',
            'responses' => ['200' => ['description' => 'Success']],
        ];
        $current['paths']['/payments/{paymentId}']['patch']['summary'] = 'Updated summary';

        $drift = OpenApiDrift::compare($baseline, $current);
        $report = OpenApiDrift::markdown($drift, '2026-10-12', '2026-10-13 00:00:00');

        self::assertTrue(OpenApiDrift::hasDrift($drift));
        self::assertSame('getPayment', $drift['operations']['removed'][0]['operationId']);
        self::assertSame('cancelPayment', $drift['operations']['added'][0]['operationId']);
        self::assertSame(['summary'], $drift['operations']['changed'][0]['changes']);
        self::assertStringContainsString('changed `summary`', $report);
    }

    public function test_schema_fields_and_requiredness_changes_are_reported(): void
    {
        $baseline = $this->document();
        $current = $baseline;
        unset($current['components']['schemas']['Payment']['properties']['storeId']);
        $current['components']['schemas']['Payment']['properties']['currency'] = ['type' => 'string'];
        $current['components']['schemas']['Payment']['properties']['amount']['type'] = 'integer';
        $current['components']['schemas']['Payment']['required'] = ['currency'];
        $current['components']['schemas']['Refund'] = ['type' => 'object', 'properties' => []];

        $drift = OpenApiDrift::compare($baseline, $current);
        $report = OpenApiDrift::markdown($drift, '2026-10-12', '2026-10-13 00:00:00');
        $payment = $drift['schemas']['changed'][0];

        self::assertTrue(OpenApiDrift::hasDrift($drift));
        self::assertContains('Refund', $drift['schemas']['added']);
        self::assertSame(['currency'], $payment['fields']['added']);
        self::assertSame(['storeId'], $payment['fields']['removed']);
        self::assertSame(['amount', 'paymentId'], $payment['fields']['changed']);
        self::assertStringContainsString('added fields: `currency`', $report);
        self::assertStringContainsString('changed fields: `amount`, `paymentId`', $report);
    }

    /**
     * @return array<string, mixed>
     */
    private function document(): array
    {
        return [
            'openapi' => '3.0.3',
            'paths' => [
                '/payments/{paymentId}' => [
                    'get' => [
                        'operationId' => 'getPayment',
                        'parameters' => [['name' => 'paymentId', 'in' => 'path', 'required' => true]],
                    ],
                    'patch' => [
                        'operationId' => 'updatePayment',
                        'summary' => 'Update payment',
                    ],
                ],
            ],
            'components' => [
                'schemas' => [
                    'Payment' => [
                        'type' => 'object',
                        'properties' => [
                            'paymentId' => ['type' => 'string'],
                            'storeId' => ['type' => 'string'],
                            'amount' => ['type' => 'number'],
                        ],
                        'required' => ['paymentId', 'storeId'],
                    ],
                    'Store' => ['type' => 'object', 'properties' => []],
                ],
            ],
        ];
    }
}
