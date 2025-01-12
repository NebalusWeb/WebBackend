<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Exception\SanitizValidationException;

class SanitizerArraySchema extends AbstractSanitizerSchema
{
    public function __construct(
        private readonly AbstractSanitizerSchema $schema
    ) {
    }

    protected function parseValue(mixed $input): array
    {
        if (! is_array($input)) {
            throw new SanitizValidationException('Not an array');
        }

        $result = [];

        foreach ($input as $v) {
            $result[] = $this->schema->parse($v);
        }

        return $result;
    }
}
