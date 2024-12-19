<?php

namespace Nebalus\Webapi\Api\Referral\Service\Analytics;

use Nebalus\Webapi\Api\Referral\View\Analytics\ReferralClickView;
use Nebalus\Webapi\Api\Referral\Validator\Analytics\ReferralClickValidator;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class ReferralClickService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(ReferralClickValidator $validator): ResultInterface
    {
        $referral = $this->referralRepository->findReferralByCode($validator->getReferralCode());

        if (empty($referral) || $referral->isDisabled()) {
            return Result::createError("Referral code not found", 404);
        }

        $this->referralRepository->insertReferralClickEntry($referral->getReferralId());

        return ReferralClickView::render($referral);
    }
}
