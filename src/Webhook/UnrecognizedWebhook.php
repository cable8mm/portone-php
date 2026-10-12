<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Webhook;

final class UnrecognizedWebhook implements Webhook
{
    /** @param array<string,mixed> $body */
    public function __construct(public readonly array $body) {}
}
