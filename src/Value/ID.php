<?php

namespace Nebalus\Webapi\Value;

use Nebalus\Webapi\Exception\ApiUnableToBuildValueObjectException;

readonly class ID
{
    private function __construct(
        private int $id
    ) {
    }

    /**
     * @throws ApiUnableToBuildValueObjectException
     */
    public static function from(int $id): self
    {
        if ($id < 0) {
            throw new ApiUnableToBuildValueObjectException(
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
