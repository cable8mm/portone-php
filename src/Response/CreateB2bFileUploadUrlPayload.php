<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

final class CreateB2bFileUploadUrlPayload extends OperationResponse
{
    public function __construct(public readonly string $fileId, public readonly string $url) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        return new self(
            self::requireString($data, 'fileId', self::class),
            self::requireString($data, 'url', self::class),
        );
    }
}
