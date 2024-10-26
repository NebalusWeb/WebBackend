<?php

namespace Nebalus\Webapi\Value\User;

readonly class TOTPCode
{
    private function __construct(
        private string $code,
    ) {
    }

    public static function from(string $code): self
    {
        return new self($code);
    }

    private function asString(): string
    {
        return $this->code;
    }
}
