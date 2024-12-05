<?php

namespace Nebalus\Webapi\Value\User;

use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class UserAgent
{
    private function __construct(
        private string $userAgent
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     */
    public static function from(string $userAgent): self
    {
        $userAgentRegEx = "/\((?<info>.*?)\)(\s|$)|(?<name>.*?)\/(?<version>.*?)(\s|$)/gm";
        if (preg_match($userAgentRegEx, $userAgent)) {
            throw new ApiInvalidArgumentException(
                'Invalid useragent'
            );
        }

        return new self($userAgent);
    }

    public function asString(): ?string
    {
        return $this->userAgent;
    }
}
