<?php

namespace Nebalus\Webapi\Value\User\Totp;

use Nebalus\Webapi\Exception\ApiUnableToBuildValueObjectException;

readonly class TOTPSecretKey
{
    private function __construct(
        private string $secret
    ) {
    }

    /**
     * @throws ApiUnableToBuildValueObjectException
     */
    public static function from(string $secret): self
    {
        $usernamePattern = '/^[\d\w]{64}$/';
        if (preg_match($usernamePattern, $secret) < 1) {
            throw new ApiUnableToBuildValueObjectException(
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
