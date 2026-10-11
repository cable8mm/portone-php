<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Exception;

final class UnknownException extends PortOneException
{
    public function __construct(
        public readonly string $operation,
        string $message,
        ?int $status = null,
        ?string $responseBody = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $status, $responseBody, $previous);
    }
}
