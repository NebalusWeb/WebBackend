<?php

namespace Nebalus\Webapi\Value\Referral;

class ReferralPointer
{
    private function __construct(
        private readonly string $pointer
    ) {
    }

    public static function from(string $pointer): self
    {
        return new self($pointer);
    }

    public function asString(): string
    {
        return $this->pointer;
    }
}
