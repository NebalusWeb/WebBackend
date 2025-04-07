<?php

namespace Nebalus\Webapi\Value;

use Nebalus\Sanitizr\Sanitizr;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class Url
{
    private function __construct(
        private string $url
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     */
    public static function from(string $url): self
    {
        $schema = Sanitizr::string()->url();
        $validData = $schema->safeParse($url);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException("Invalid url: " . $validData->getErrorMessage());
        }

        return new self($validData->getValue());
    }

    public function asString(): string
    {
        return $this->url;
    }
}
