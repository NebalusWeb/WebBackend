<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Exception\SanitizValidationException;
use Nebalus\Webapi\Utils\Sanitizr\Schema\AbstractSchema;

class IntegerSchema extends AbstractSchema
{
    private $min;
    private $max;

    public function min(int $min)
    {
        $this->min = $min;
        return $this;
    }

    public function max(int $max)
    {
        $this->max = $max;
        return $this;
    }

    public function positive()
    {
        return $this->min(1);
    }

    public function negative()
    {
        return $this->max(-1);
    }

    /**
     * @throws SanitizValidationException
     */
    protected function parseValue($value): int
    {
        if (! is_numeric($value)) {
            throw new SanitizValidationException('Not a numeric value');
        }
        if (is_string($value)) {
            throw new SanitizValidationException('Numeric value is a string');
        }
        if (! is_null($this->min) && $value < $this->min) {
            throw new SanitizValidationException('Value is too small');
        }
        if (! is_null($this->max) && $this->max < $value) {
            throw new SanitizValidationException('Value is too big');
        }
        return $value;
    }
}
