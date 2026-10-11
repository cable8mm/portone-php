<?php

declare(strict_types=1);

namespace Cable8mm\PortonePhp\Response;

/**
 * A forward-compatible OpenAPI oneOf response selected by a discriminator.
 *
 * The complete payload remains available through OperationResponse::$data while
 * the discriminator and whether this SDK knows the variant are explicit.
 */
class DiscriminatedResponse extends OperationResponse
{
    /** @param array<string,mixed> $data */
    public function __construct(
        array $data,
        public readonly string $variant,
        public readonly bool $knownVariant,
    ) {
        parent::__construct($data);
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  list<string>  $knownVariants
     */
    protected static function decodeVariant(array $data, string $field, array $knownVariants): array
    {
        $variant = self::requireString($data, $field, static::class);

        return [$variant, in_array($variant, $knownVariants, true)];
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  list<string>  $required
     */
    protected static function requireFields(array $data, array $required): void
    {
        foreach ($required as $field) {
            if (! array_key_exists($field, $data)) {
                throw new \UnexpectedValueException(static::class.' must contain a '.$field.' field.');
            }
        }
    }
}
