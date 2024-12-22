<?php

namespace Nebalus\Webapi\Value\Referral\Click;

use Nebalus\Webapi\Value\Referral\ReferralId;
use DateTimeImmutable;

class ReferralClick
{
    private function __construct(
        private readonly ReferralClickId $referralClickId,
        private readonly ReferralId $referralId,
        private readonly DateTimeImmutable $clickedAt
    ) {
    }

    public static function from(ReferralClickId $referralClickId, ReferralId $referralId, DateTimeImmutable $clickedAt): self
    {
        return new self($referralClickId, $referralId, $clickedAt);
    }

    public function getReferralClickId(): ReferralClickId
    {
        return $this->referralClickId;
    }

    public function getReferralId(): ReferralId
    {
        return $this->referralId;
    }

    public function getClickedAt(): DateTimeImmutable
    {
        return $this->clickedAt;
    }
}
