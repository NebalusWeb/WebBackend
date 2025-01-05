<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

use Nebalus\Webapi\Utils\Sanitizr\Schema\AbstractSchema;

class FloatSchema extends AbstractSchema
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
