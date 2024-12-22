<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Exception\SanitizValidationException;

abstract class AbstractSchema
{
    private bool $nullable = false;

    public function nullable(): self
    {
        $this->nullable = true;
        return $this;
    }

    public function parse($value): array
    {
        return $this->parseValue($value);
    }

    public function safeParse($value): array
    {
        try {
            $result = $this->parse($value);
            return array(
                'success' => true,
                'data'    => $result,
            );
        } catch (SanitizValidationException $e) {
            return array(
                'success' => false,
                'error'   => $e->getMessage(),
            );
        }
    }

    abstract protected function parseValue($value): mixed;
}
