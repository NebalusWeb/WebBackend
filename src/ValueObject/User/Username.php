<?php

namespace Nebalus\Webapi\ValueObject\User;

use InvalidArgumentException;

readonly class Username
{
    private function __construct(
        private string $username
    ) {
    }

    public static function from(string $username): self
    {
        if (strlen($username) < 4) {
            throw new InvalidArgumentException(
                'Invalid username: must be at least 4 characters long'
            );
        }

        if (strlen($username) > 25) {
            throw new InvalidArgumentException(
                'Invalid username: cannot be longer than 25 characters'
            );
        }

        $usernamePattern = '/^[a-zA-Z]+$/';
        if (preg_match($usernamePattern, $username) < 1) {
            throw new InvalidArgumentException(
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
