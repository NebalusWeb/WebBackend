<?php

namespace Nebalus\Webapi\Value\Referral\Click;

use DateTimeImmutable;
use Nebalus\Sanitizr\Sanitizr;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class ReferralClick
{
    private function __construct(
        private DateTimeImmutable $clickedAt,
        private int $clickAmount
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     */
    public static function from(DateTimeImmutable $clickedAt, int $clickAmount): self
    {
        $schema = Sanitizr::number()->integer()->positive();
        $validData = $schema->safeParse($clickAmount);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException('Invalid click amount: ' . $validData->getErrorMessage());
        }

        return new self($clickedAt, $clickAmount);
    }

    public function getClickedAt(): DateTimeImmutable
    {
        return $this->clickedAt;
    }

    public function getClickAmount(): int
    {
        return $this->clickAmount;
    }
}
