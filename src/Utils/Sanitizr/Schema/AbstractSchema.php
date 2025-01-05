<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Exception\SanitizValidationException;

abstract class AbstractSchema
{
    private bool $isRequired = false;
    private bool $isNullable = false;

    public function required(): static
    {
        $this->isRequired = true;
        return $this;
    }

    public function nullable(): static
    {
        $this->isNullable = true;
        return $this;
    }

    public function parse(mixed $value): mixed
    {


        if ($this->isNullable && is_null($value)) {
            return null;
        }

        return $this->parseValue($value);
    }

    public function safeParse(mixed $value): array
    {
        try {
            $result = $this->parse($value);
            return [
                'success' => true,
                'data'    => $result,
            ];
        } catch (SanitizValidationException $e) {
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    abstract protected function parseValue(mixed $value): mixed;
}
