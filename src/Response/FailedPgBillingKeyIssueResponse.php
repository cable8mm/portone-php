<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class FailedPgBillingKeyIssueResponse extends OperationResponse
{
    /**
     * @param  array<string, mixed>  $channel
     * @param  array<string, mixed>  $failure
     */
    public function __construct(
        private readonly array $channel,
        public readonly array $failure,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireObject($data, 'channel', self::class),
            self::requireObject($data, 'failure', self::class),
        );
    }

    /** @return array<string,mixed> */
    public function channel(): array
    {
        return $this->channel;
    }
}
