<?php

namespace Nebalus\Webapi\Value\Module\Referral\Click;

use DateMalformedStringException;
use DateTimeImmutable;
use Nebalus\Webapi\Exception\ApiDateMalformedStringException;
use Nebalus\Webapi\Exception\ApiException;

readonly class ReferralClick
{
    private function __construct(
        private DateTimeImmutable $clickedAtDate,
        private ReferralClickAmount $clickCount,
        private ReferralClickAmount $uniqueVisitorsCount,
    ) {
    }

    /**
     * @throws ApiException
     */
    public static function fromArray(array $data): self
    {
        try {
            $clickedAtDate = new DateTimeImmutable($data["clicked_at"]);
        } catch (DateMalformedStringException $exception) {
            throw new ApiDateMalformedStringException($exception);
        }

        $clickCount = ReferralClickAmount::from($data["click_count"]);
        $uniqueVisitorsCount = ReferralClickAmount::from($data["unique_visitors"]);

        return new self($clickedAtDate, $clickCount, $uniqueVisitorsCount);
    }

    public function getClickedAtDate(): DateTimeImmutable
    {
        return $this->clickedAtDate;
    }

    public function getClickCount(): ReferralClickAmount
    {
        return $this->clickCount;
    }

    public function getUniqueVisitorsCount(): ReferralClickAmount
    {
        return $this->uniqueVisitorsCount;
    }
}
