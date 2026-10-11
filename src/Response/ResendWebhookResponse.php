<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class ResendWebhookResponse extends OperationResponse
{
    /** @param array<string,mixed> $webhook */
    public function __construct(public readonly array $webhook) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['webhook'] ?? null)) {
            throw new \UnexpectedValueException('ResendWebhookResponse must contain a webhook object.');
        }

        return new self($data['webhook']);
    }
}
