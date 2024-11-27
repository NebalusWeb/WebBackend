<?php

namespace Nebalus\Webapi\Value\Referral;

class ReferralCode
{
    private function __construct(
        private readonly string $code
    ) {
    }

    public static function from(string $code): self
    {
        return new self($code);
    }

    public function asString(): string
    {
        return $this->code;
    }
}
