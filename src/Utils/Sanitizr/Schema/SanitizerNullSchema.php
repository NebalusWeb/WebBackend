<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Exception\SanitizValidationException;

class SanitizerNullSchema extends AbstractSanitizerSchema
{
    protected function parseValue(mixed $input): null
    {
        if (! is_null($input)) {
            throw new SanitizValidationException('Not a null value');
        }

        return null;
    }
}
