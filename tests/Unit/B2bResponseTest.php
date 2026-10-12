<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Model\B2bBulkTaxInvoice;
use Cable8mm\PortonePhp\Model\B2bTaxInvoice;
use Cable8mm\PortonePhp\Model\CreateB2bCounterpartyResponse;
use Cable8mm\PortonePhp\Model\GetB2bBusinessInfosResponse;
use Cable8mm\PortonePhp\Model\GetB2bCounterpartiesResponse;
use Cable8mm\PortonePhp\Model\GetB2bTaxInvoiceAttachmentsResponse;
use Cable8mm\PortonePhp\Model\GetB2bTaxInvoicesResponse;
use Cable8mm\PortonePhp\Model\IssueB2bTaxInvoiceResponse;
use PHPUnit\Framework\TestCase;

final class B2bResponseTest extends TestCase
{
    public function test_b2b_object_and_list_envelopes_expose_fields(): void
    {
        self::assertSame(['id' => 'counterparty-id'], CreateB2bCounterpartyResponse::fromArray([
            'counterparty' => ['id' => 'counterparty-id'],
        ])->counterparty);
        self::assertSame([['id' => 'business-id']], GetB2bBusinessInfosResponse::fromArray([
            'result' => [['id' => 'business-id']],
        ])->result);
        $counterparties = GetB2bCounterpartiesResponse::fromArray([
            'items' => [[
                'id' => 'counterparty-id', 'graphqlId' => 'graphql-id', 'isForTest' => true,
                'brn' => '1234567890', 'companyName' => 'Company', 'representativeName' => 'Owner',
                'contact' => [], 'additionalContacts' => [], 'ntsConnectionStatus' => 'NOT_CONNECTED',
            ]],
            'page' => ['number' => 0],
        ])->items;
        self::assertSame('counterparty-id', $counterparties[0]->id);
        self::assertSame([['id' => 'attachment-id']], GetB2bTaxInvoiceAttachmentsResponse::fromArray([
            'attachments' => [['id' => 'attachment-id']],
        ])->attachments);
        self::assertSame(['id' => 'invoice-id'], IssueB2bTaxInvoiceResponse::fromArray([
            'taxInvoice' => ['id' => 'invoice-id'],
        ])->taxInvoice);
        self::assertSame(['number' => 0], GetB2bTaxInvoicesResponse::fromArray([
            'items' => [],
            'page' => ['number' => 0],
        ])->page);
    }

    public function test_b2b_envelopes_reject_invalid_list_members(): void
    {
        $cases = [
            static fn (): mixed => GetB2bBusinessInfosResponse::fromArray(['result' => ['invalid']]),
            static fn (): mixed => GetB2bCounterpartiesResponse::fromArray(['items' => 'invalid', 'page' => []]),
            static fn (): mixed => GetB2bTaxInvoiceAttachmentsResponse::fromArray(['attachments' => ['invalid']]),
            static fn (): mixed => GetB2bTaxInvoicesResponse::fromArray(['items' => [], 'page' => 'invalid']),
        ];

        foreach ($cases as $case) {
            try {
                $case();
                self::fail('Expected an invalid B2B response envelope to be rejected.');
            } catch (\UnexpectedValueException) {
                self::assertTrue(true);
            }
        }
    }

    public function test_tax_invoice_and_bulk_models_validate_required_openapi_fields(): void
    {
        $invoice = B2bTaxInvoice::fromArray([
            'id' => 'invoice-id', 'status' => 'DRAFTED', 'taxationType' => 'TAX',
            'documentModificationType' => 'ORIGINAL', 'issuanceType' => 'NORMAL',
            'writeDate' => '2026-10-12', 'issuanceDueDate' => '2026-10-12',
            'purposeType' => 'SUPPLY', 'totalSupplyAmount' => 1000, 'totalTaxAmount' => 100,
            'totalAmount' => 1100, 'remarks' => [], 'supplier' => [], 'recipient' => [],
            'items' => [], 'additionalContacts' => [],
        ]);
        self::assertSame('invoice-id', $invoice->id);

        $bulk = B2bBulkTaxInvoice::fromArray([
            'id' => 'bulk-id', 'graphqlId' => 'graphql-id', 'status' => 'DRAFTED',
            'totalInvoiceCount' => 1, 'totalAmount' => 1100, 'stats' => [],
            'createdAt' => '2026-10-12T00:00:00Z', 'statusUpdatedAt' => '2026-10-12T00:00:00Z',
            'sourceType' => 'FILE', 'issuanceType' => 'NORMAL',
        ]);
        self::assertSame('bulk-id', $bulk->id);
    }
}
