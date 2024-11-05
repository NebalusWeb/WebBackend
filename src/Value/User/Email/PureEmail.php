<?php

namespace Nebalus\Webapi\Value\User\Email;

use InvalidArgumentException;

readonly class PureEmail
{
    private function __construct(
        private string $email,
    ) {
    }

    public static function from(string $email): self
    {
        $emailRegEx = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';

        if (preg_match($emailRegEx, $email) === false) {
            throw new InvalidArgumentException('Invalid email: ' . $email);
        }

        return new self($email);
    }

    public function asString(): string
    {
        return $this->email;
    }
}
