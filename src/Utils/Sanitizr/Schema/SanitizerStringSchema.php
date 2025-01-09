<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Exception\SanitizValidationException;

class SanitizerStringSchema extends AbstractSanitizerSchema
{
    // Validations
    private bool $isEmail = false;
    private int $min;
    private int $max;
    private string $regex;
    private string $startsWith;
    private string $endsWith;

    public function email(): static
    {
        $this->
        return $this;
    }

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

    public function length(int $length): static
    {
        return $this->min($length)->max($length);
    }

    public function regex(string $regex): static
    {
        $this->regex = $regex;
        return $this;
    }

    public function startsWith(string $startsWith): static
    {
        $this->startsWith = $startsWith;
        return $this;
    }

    public function endsWith(string $endsWith): static
    {
        $this->endsWith = $endsWith;
        return $this;
    }

    /**
     * @throws SanitizValidationException
     */
    protected function parseValue(mixed $value): string
    {
        // Validations
        if (! is_string($value)) {
            throw new SanitizValidationException('Not a string value');
        }

        if ($this->isEmail && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new SanitizValidationException('Not a valid email');
        }

        if (isset($this->min) && strlen($value) <= $this->min) {
            throw new SanitizValidationException('String is too short');
        }

        if (isset($this->max) && $this->max <= strlen($value)) {
            throw new SanitizValidationException('String is too long');
        }

        if (isset($this->regex) && ! preg_match($this->regex, $value)) {
            throw new SanitizValidationException('String does not match regex');
        }

        if (isset($this->startsWith) && str_starts_with($value, $this->startsWith)) {
            throw new SanitizValidationException('String does not start with required string');
        }

        if (isset($this->endsWith) && str_ends_with($value, $this->endsWith)) {
            throw new SanitizValidationException('String does not end with required string');
        }

        return $value;
    }
}
