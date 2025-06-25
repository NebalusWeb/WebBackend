<?php

namespace Nebalus\Webapi\Value;

use Nebalus\Webapi\Exception\ApiException;

class Range
{
    private function __construct(
        private readonly int $min,
        private readonly int $max
    ) {
    }

    public static function from(int $min, int $max): self
    {
        if ($min > $max) {
            $maxTemp = $max;
            $max = $min;
            $min = $maxTemp;
        }
        return new self($min, $max);
    }

    public function isInRange(int $value): bool
    {
        return $value >= $this->min && $value <= $this->max;
    }
}
