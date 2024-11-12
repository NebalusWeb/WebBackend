<?php

namespace Nebalus\Webapi\Value;

use InvalidArgumentException;

readonly class ID
{
    private function __construct(
        private int $id
    ) {
    }

    public static function from(int $id): self
    {
        if ($id < 0) {
            throw new InvalidArgumentException(
                'Invalid referralId: must be a non-negative integer'
            );
        }

        return new self($id);
    }

    public function asInt(): int
    {
        return $this->id;
    }

    public function asString(): string
    {
        return (string) $this->id;
    }
}
