<?php

namespace Nebalus\Webapi\Value\User;

use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Sanitizr\Sanitizr;

readonly class UserAgent
{
    public const string REGEX = "/\((?<info>.*?)\)(\s|$)|(?<name>.*?)\/(?<version>.*?)(\s|$)/";

    private function __construct(
        private string $userAgent
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     */
    public static function from(string $userAgent): self
    {
        $schema = Sanitizr::string()->regex(self::REGEX);
        $validData = $schema->safeParse($userAgent);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException('Invalid useragent: ' . $validData->getErrorMessage());
        }

        return new self($userAgent);
    }

    public function asString(): ?string
    {
        return $this->userAgent;
    }
}
