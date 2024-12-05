<?php

namespace Nebalus\Webapi\Value\Referral;

readonly class ReferralCode
{
    private function __construct(
        private string $code
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
