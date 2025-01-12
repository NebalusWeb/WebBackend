<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Exception\SanitizValidationException;
use Nebalus\Webapi\Utils\Sanitizr\Schema\AbstractSanitizerSchema;

class SanitizerFloatSchema extends AbstractSanitizerSchema
{
    protected function parseValue(mixed $value): float
    {
        if (! is_numeric($value)) {
            throw new SanitizValidationException('Not a numeric value');
        }

        if (! is_float($value)) {
            throw new SanitizValidationException('Not a float value');
        }

        return $value;
    }
}
