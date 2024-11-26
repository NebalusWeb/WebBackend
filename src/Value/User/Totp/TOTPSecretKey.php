<?php

namespace Nebalus\Webapi\Value\User\Totp;

use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class TOTPSecretKey
{
    private function __construct(
        private string $secret
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     */
    public static function from(string $secret): self
    {
        $usernamePattern = '/^[\d\w]{32}$/';
        if (preg_match($usernamePattern, $secret) < 1) {
            throw new ApiInvalidArgumentException(
                'Invalid totp code secret'
            );
        }
        return new self($secret);
    }

    public function asString(): string
    {
        return $this->secret;
    }
}
