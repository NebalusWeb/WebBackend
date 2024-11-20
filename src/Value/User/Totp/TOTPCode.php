<?php

namespace Nebalus\Webapi\Value\User\Totp;

use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class TOTPCode
{
    private function __construct(
        private string $code,
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     */
    public static function from(string $code): self
    {
        $usernamePattern = '/^[\d]{6}$/';
        if (preg_match($usernamePattern, $code) < 1) {
            throw new ApiInvalidArgumentException(
                'Invalid totp code'
            );
        }
        return new self($code);
    }

    private function asString(): string
    {
        return $this->code;
    }
}
