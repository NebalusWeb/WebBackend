<?php

namespace Nebalus\Webapi\Value\User;

use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

class Username
{
    private function __construct(
        private readonly string $username
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     */
    public static function from(string $username): self
    {
        if (strlen($username) < 4) {
            throw new ApiInvalidArgumentException(
                'Invalid username: must be at least 4 characters long'
            );
        }

        if (strlen($username) > 25) {
            throw new ApiInvalidArgumentException(
                'Invalid username: cannot be longer than 25 characters'
            );
        }

        $usernamePattern = '/^[a-zA-Z]+$/';
        if (preg_match($usernamePattern, $username) < 1) {
            throw new ApiInvalidArgumentException(
                'Invalid username: can only contain letters'
            );
        }

        return new self($username);
    }

    public function asString(): string
    {
        return $this->username;
    }
}
