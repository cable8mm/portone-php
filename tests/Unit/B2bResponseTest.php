<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Tests\Unit;

use Cable8mm\PortonePhp\Response\CreateB2bCounterpartyResponse;
use Cable8mm\PortonePhp\Response\GetB2bBusinessInfosResponse;
use Cable8mm\PortonePhp\Response\GetB2bCounterpartiesResponse;
use Cable8mm\PortonePhp\Response\GetB2bTaxInvoiceAttachmentsResponse;
use Cable8mm\PortonePhp\Response\GetB2bTaxInvoicesResponse;
use Cable8mm\PortonePhp\Response\IssueB2bTaxInvoiceResponse;
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
        self::assertSame([['id' => 'counterparty-id']], GetB2bCounterpartiesResponse::fromArray([
            'items' => [['id' => 'counterparty-id']],
            'page' => ['number' => 0],
        ])->items);
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
}
