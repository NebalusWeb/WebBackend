<?php

namespace Nebalus\Webapi\Value\User;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class UserEmail
{
    private const string REGEX = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';

    private function __construct(
        private string $email,
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function from(string $email): self
    {
        if (preg_match(self::REGEX, $email) === false) {
            throw new ApiInvalidArgumentException('Invalid email');
        }

        return new self($email);
    }

    public function asString(): string
    {
        return $this->email;
    }
}
