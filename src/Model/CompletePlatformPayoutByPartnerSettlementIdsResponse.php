<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class CompletePlatformPayoutByPartnerSettlementIdsResponse extends OperationResponse
{
    public function __construct(
        public readonly ?string $bulkPayoutId,
        public readonly ?string $bulkPayoutGraphqlId,
        public readonly int $payoutCount,
        public readonly int $partnerSettlementCount,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        foreach (['bulkPayoutId', 'bulkPayoutGraphqlId'] as $field) {
            if (($data[$field] ?? null) !== null && ! is_string($data[$field])) {
                throw new \UnexpectedValueException('CompletePlatformPayoutByPartnerSettlementIdsResponse contains invalid '.$field.'.');
            }
        }
        if (! is_int($data['payoutCount'] ?? null) || ! is_int($data['partnerSettlementCount'] ?? null)) {
            throw new \UnexpectedValueException('CompletePlatformPayoutByPartnerSettlementIdsResponse contains invalid counts.');
        }

        return new self($data['bulkPayoutId'] ?? null, $data['bulkPayoutGraphqlId'] ?? null, $data['payoutCount'], $data['partnerSettlementCount']);
    }
}
