<?php

namespace Nebalus\Webapi\Value\User\Totp;

use InvalidArgumentException;

readonly class TOTPSecretKey
{
    private function __construct(
        private string $secret
    ) {
    }

    public static function from(string $secret): self
    {
        $usernamePattern = '/^[\d\w]{64}$/';
        if (preg_match($usernamePattern, $secret) < 1) {
            throw new InvalidArgumentException(
                'Invalid totp code secret'
            );
        }
        return new self($secret);
    }

    private function asString(): string
    {
        return $this->secret;
    }
}
