<?php

namespace Nebalus\Webapi\Value\User;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class Username
{
    private const int MIN_LENGTH = 4;
    private const int MAX_LENGTH = 25;
    private const string REGEX = '/^[a-zA-Z]+$/';

    private function __construct(
        private string $username
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function from(string $username): self
    {
        if (strlen($username) < self::MIN_LENGTH) {
            throw new ApiInvalidArgumentException(
                'Invalid username: must be at least ' . self::MIN_LENGTH . ' characters long'
            );
        }

        if (strlen($username) > self::MAX_LENGTH) {
            throw new ApiInvalidArgumentException(
                'Invalid username: cannot be longer than ' . self::MAX_LENGTH . ' characters'
            );
        }

        if (preg_match(self::REGEX, $username) === false) {
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
