<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Exception\SanitizValidationException;
use Nebalus\Webapi\Utils\Sanitizr\Schema\AbstractSanitizerSchema;

class SanitizerIntegerSchema extends AbstractSanitizerSchema
{
    private int $min;
    private int $max;

    public function min(int $min): static
    {
        $this->min = $min;
        return $this;
    }

    public function max(int $max): static
    {
        $this->max = $max;
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

        if (is_string($value)) {
            throw new SanitizValidationException('Numeric value is a string');
        }

        if (isset($this->min) && $value < $this->min) {
            throw new SanitizValidationException('Value is too small');
        }

        if (isset($this->max) && $this->max < $value) {
            throw new SanitizValidationException('Value is too big');
        }

        return $value;
    }
}
