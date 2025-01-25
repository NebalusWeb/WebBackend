<?php

namespace Nebalus\Webapi\Value\Module\Referral\Click;

use Nebalus\Sanitizr\Sanitizr;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;

readonly class ReferralClickCount
{
    private function __construct(
        private int $clickAmount
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     */
    public static function from(int $clickAmount): self
    {
        $schema = Sanitizr::number()->integer()->positive();
        $validData = $schema->safeParse($clickAmount);

        if ($validData->isError()) {
            throw new ApiInvalidArgumentException('Invalid click amount: ' . $validData->getErrorMessage());
        }

        return new self($clickAmount);
    }

    public function asInt(): int
    {
        return $this->clickAmount;
    }
}
