<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Exception\SanitizValidationException;

abstract class AbstractSchema
{
    private $isOptional = false;
    public function optional()
    {
        $this->isOptional = true;
    }

    public function parse($value)
    {
        if ($this->isOptional && is_null($value)) {
            return null;
        }

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
