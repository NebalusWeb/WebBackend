<?php

namespace Nebalus\Webapi\Value\Referral;

use IteratorAggregate;
use Traversable;

class Referrals implements IteratorAggregate
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

    public function getIterator(): Traversable
    {
        yield from $this->referrals;
    }
}
