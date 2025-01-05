<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Exception\SanitizValidationException;
use Nebalus\Webapi\Utils\Sanitizr\Schema\AbstractSchema;

class IntegerSchema extends AbstractSchema
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

    public function positive(): static
    {
        return $this->min(1);
    }

    public function negative(): static
    {
        return $this->max(-1);
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
