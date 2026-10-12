<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Model;

final class UpdatePlatformSettingResponse extends OperationResponse
{
    public function __construct(public readonly array $setting) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): static
    {
        if (! is_array($data['setting'] ?? null)) {
            throw new \UnexpectedValueException('UpdatePlatformSettingResponse must contain a setting object.');
        }

        return new self($data['setting']);
    }
}
