<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class IssuedPgBillingKeyIssueResponse extends OperationResponse
{
    /** @param array<string,mixed> $channel @param array<string,mixed>|null $method */
    public function __construct(
        private readonly array $channel,
        public readonly ?string $pgTxId,
        public readonly ?array $method,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        $method = $data['method'] ?? null;
        if ($method !== null && ! is_array($method)) {
            throw new \UnexpectedValueException(self::class.' must contain a method object or null.');
        }

        $pgTxId = $data['pgTxId'] ?? null;
        if ($pgTxId !== null && ! is_string($pgTxId)) {
            throw new \UnexpectedValueException(self::class.' must contain a pgTxId string or null.');
        }

        return new self(
            self::requireObject($data, 'channel', self::class),
            $pgTxId,
            $method,
        );
    }

    /** @return array<string,mixed> */
    public function channel(): array
    {
        return $this->channel;
    }
}
