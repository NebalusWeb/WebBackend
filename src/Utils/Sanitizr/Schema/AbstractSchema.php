<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Exception\SanitizValidationException;
use Nebalus\Webapi\Utils\Sanitizr\SafeParsedData;

abstract class AbstractSchema
{
    private mixed $defaultValue;
    private bool $isNullable = false;

    public function default(mixed $value): static
    {
        $this->defaultValue = $value;
        return $this;
    }

    public function nullable(): static
    {
        $this->isNullable = true;
        return $this;
    }

    /**
     * @throws SanitizValidationException
     */
    public function parse(mixed $value): mixed
    {
        if ($this->isNullable && is_null($value)) {
            return null;
        }

        if (isset($defaultValue) && $this->isNullable === false && $value === null) {
            return $this->parseValue($defaultValue);
        }

        return $this->parseValue($value);
    }

    public function safeParse(mixed $value): SafeParsedData
    {
        try {
            $result = $this->parse($value);
            return SafeParsedData::from(true, $result, null);
        } catch (SanitizValidationException $e) {
            return SafeParsedData::from(false, null, $e->getMessage());
        }
    }

    /**
     * @throws SanitizValidationException
     */
    abstract protected function parseValue(mixed $value): mixed;
}
