<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Exception\SanitizValidationException;
use Nebalus\Webapi\Utils\Sanitizr\Schema\AbstractSanitizerSchema;

class SanitizerIntegerSchema extends AbstractSanitizerSchema
{
    public function positive(string $message = 'Must be a positive number'): static
    {
        $this->addEffect(function (int $value) use ($message) {
            if ($value <= 0) {
                throw new SanitizValidationException($message);
            }
        });

        return $this;
    }

    /**
     * @throws SanitizValidationException
     */
    protected function parseValue(mixed $value): int
    {
        if (! is_numeric($value)) {
            throw new SanitizValidationException('Not a numeric value');
        }

        if (! is_int($value)) {
            throw new SanitizValidationException('Not an integer value');
        }

        return $value;
    }
}
