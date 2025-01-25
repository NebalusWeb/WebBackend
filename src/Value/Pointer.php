<?php

namespace Nebalus\Webapi\Value;

use Nebalus\Sanitizr\Sanitizr;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class Pointer
{
    private function __construct(
        private string $pointer
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     */
    public static function from(string $pointer): self
    {
        $schema = Sanitizr::string()->url();
        $validData = $schema->safeParse($pointer);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException("Invalid pointer: " . $validData->getErrorMessage());
        }

        return new self($pointer);
    }

    public function asString(): string
    {
        return $this->pointer;
    }
}
