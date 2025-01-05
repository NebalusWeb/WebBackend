<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Schema\AbstractSanitizerSchema;

class SanitizerFloatSchema extends AbstractSanitizerSchema
{
    private float $min;
    private float $max;

    public function min(float $min): static
    {
        $this->min = $min;
        return $this;
    }

    public function max(float $max): static
    {
        $this->max = $max;
        return $this;
    }

    protected function parseValue(mixed $value): mixed
    {
        // TODO: Implement parseValue() method.
    }
}
