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
        private ReferralClickCount $clickCount
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

        $clickAmount = ReferralClickCount::from($data["click_count"]);

        return new self($clickedAtDate, $clickAmount);
    }

    public function getClickedAtDate(): DateTimeImmutable
    {
        return $this->clickedAtDate;
    }

    public function getClickCount(): ReferralClickCount
    {
        return $this->clickCount;
    }
}
