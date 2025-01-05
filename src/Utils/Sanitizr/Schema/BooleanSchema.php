<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Exception\SanitizValidationException;

class BooleanSchema extends AbstractSchema
{
    /**
     * @throws SanitizValidationException
     */
    protected function parseValue($value): bool
    {
        if (! is_bool($value)) {
            throw new SanitizValidationException('Not a boolean value');
        }

        return $value;
    }
}
