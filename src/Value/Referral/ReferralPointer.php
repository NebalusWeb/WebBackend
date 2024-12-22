<?php

namespace Nebalus\Webapi\Value\Referral;

readonly class ReferralPointer
{
    private function __construct(
        private string $pointer
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
