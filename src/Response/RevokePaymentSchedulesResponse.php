<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class RevokePaymentSchedulesResponse extends OperationResponse
{
    /** @param list<string> $revokedScheduleIds */
    public function __construct(
        public readonly ?string $revokedAt,
        public readonly array $revokedScheduleIds,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::optionalString($data, 'revokedAt', self::class),
            self::requireStringList($data, 'revokedScheduleIds', self::class),
        );
    }
}
