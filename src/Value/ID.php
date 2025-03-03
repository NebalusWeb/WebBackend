<?php

namespace Nebalus\Webapi\Value;

use Nebalus\Sanitizr\Sanitizr;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class ID
{
    private function __construct(
        private int $id
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function from(mixed $id): self
    {
        $schema = Sanitizr::number()->integer()->positive();
        $validData = $schema->safeParse($id);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException('Invalid id: ' . $validData->getErrorMessage());
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
