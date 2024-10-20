<?php

namespace Nebalus\Webapi\ValueObject\User;

use InvalidArgumentException;

readonly class UserAdminDescription
{
    private function __construct(
        private ?string $description
    ) {
    }

    public static function from(?string $description): self
    {
        if ($description === '' || $description === null) {
            return new self(null);
        }

        return new self($description);
    }

    public function asString(): ?string
    {
        return $this?->description;
    }
}
