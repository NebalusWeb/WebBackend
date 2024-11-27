<?php

namespace Nebalus\Webapi\Value;

use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

class ID
{
    private function __construct(
        private readonly int $id
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     */
    public static function from(int $id): self
    {
        if ($id < 0) {
            throw new ApiInvalidArgumentException(
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
