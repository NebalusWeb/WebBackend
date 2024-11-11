<?php

namespace Nebalus\Webapi\Value\Referral;

class Referrals
{
    private array $referrals;

    private function __construct(Referral ...$referrals)
    {
        $this->referrals = $referrals;
    }

    public static function fromArray(Referral ...$referrals): self
    {
        return new self(...$referrals);
    }

    public function getReferrals(): array
    {
        return $this->referrals;
    }
}
