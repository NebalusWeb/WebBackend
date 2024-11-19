<?php

namespace Nebalus\Webapi\Value\User;

use InvalidArgumentException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class UserEmail
{
    private function __construct(
        private string $email,
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     */
    public static function from(string $email): self
    {
        $emailRegEx = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';

        if (preg_match($emailRegEx, $email) === false) {
            throw new ApiInvalidArgumentException('Invalid email');
        }

        return new self($email);
    }

    public function asString(): string
    {
        return $this->email;
    }
}
