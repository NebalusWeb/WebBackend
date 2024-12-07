<?php

namespace Nebalus\Webapi\Value;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

trait ID
{
    private function __construct(
        private readonly int $id
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function from(int $id): self
    {
        if ($id < 0) {
            throw new ApiInvalidArgumentException(
                'Invalid id: must be a non-negative integer'
            );
        }

        return new self($id);
    }

    /**
     * @throws ApiException
     */
    public static function fromString(string $id): self
    {
        if (is_numeric($id) === false) {
            throw new ApiInvalidArgumentException(
                'Invalid id: must be a number'
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
