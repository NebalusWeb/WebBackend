<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Exception\SanitizValidationException;
use Nebalus\Webapi\Utils\Sanitizr\Value\SafeParsedData;

abstract class AbstractSanitizerSchema
{
    private array $effectQueue = [];
    private bool $isNullable = false;
    private mixed $defaultValue;

    protected function addEffect(callable $callable): void
    {
        $this->effectQueue[] = [$callable];
    }

    public function nullable(): static
    {
        $this->isNullable = true;
        return $this;
    }

    public function default(mixed $value): static
    {
        $this->defaultValue = $value;
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

        if (is_null($value) && isset($this->defaultValue)) {
            return $this->defaultValue;
        }

        $parsedValue = $this->parseValue($value);

        foreach ($this->effectQueue as $effect) {
            $effect[0]($parsedValue);
        }

        return $parsedValue;
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
