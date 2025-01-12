<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Exception\SanitizValidationException;

class SanitizerObjectSchema extends AbstractSanitizerSchema
{
    public function __construct(
        private readonly array $schemas
    ) {
    }

    /**
     * @throws SanitizValidationException
     */
    protected function parseValue(mixed $value): array
    {
        if (is_object($value)) {
            $value = get_object_vars($value);
        }

        if (!is_array($value)) {
            throw new SanitizValidationException('Not an object');
        }

        $result = [];

        foreach ($this->schemas as $prop => $schema) {
            $result[$prop] = $schema->parse(
                $value[$prop] ?? null
            );
        }

        //return array_filter($result, fn($p) => !is_null($p));
        return $result;
    }
}
