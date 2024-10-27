<?php

namespace Nebalus\Webapi\Value\Referral;

use InvalidArgumentException;

readonly class ReferralId
{
    private function __construct(
        private int $referralId
    ) {
    }

    public static function from(int $referralId): self
    {
        if ($referralId < 0) {
            throw new InvalidArgumentException(
                'Invalid referralId: must be a non-negative integer'
            );
        }

        return new self($referralId);
    }

    public function asInt(): int
    {
        return $this->referralId;
    }

    public function asString(): string
    {
        return (string) $this->referralId;
    }
}
