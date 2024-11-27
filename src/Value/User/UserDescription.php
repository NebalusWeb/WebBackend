<?php

namespace Nebalus\Webapi\Value\User;

class UserDescription
{
    private function __construct(
        private readonly ?string $description
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
