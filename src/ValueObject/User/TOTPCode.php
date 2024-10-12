<?php

namespace Nebalus\Webapi\ValueObject\User;

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

    private function __toString(): string
    {
        return $this->code;
    }
}
