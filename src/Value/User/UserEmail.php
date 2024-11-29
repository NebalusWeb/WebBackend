<?php

namespace Nebalus\Webapi\Value\User;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

class UserEmail
{
    private function __construct(
        private readonly string $email,
    ) {
    }

    /**
     * @throws ApiException
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
