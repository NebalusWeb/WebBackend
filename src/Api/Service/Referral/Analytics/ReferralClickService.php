<?php

namespace Nebalus\Webapi\Api\Service\Referral\Analytics;

use DateMalformedStringException;
use Nebalus\Webapi\Api\Filter\Referral\Analytics\ReferralClickFilter;
use Nebalus\Webapi\Api\View\Referral\Analytics\ReferralClickView;
use Nebalus\Webapi\Repository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Referral\ReferralCode;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class ReferralClickService
{
    public function __construct(
        private ReferralClickFilter $referralClickFilter,
        private MySQlReferralRepository $referralRepository
    ) {
    }

    /**
     * @throws DateMalformedStringException
     */
    public function execute(array $params): ResultInterface
    {
        if ($this->referralClickFilter->filterAndCheckIfStructureIsValid($params) === false) {
            return Result::createError($this->referralClickFilter->getErrorMessage(), 400);
        }

        $filteredData = $this->referralClickFilter->getFilteredData();

        $referral = $this->referralRepository->findReferralByCode(ReferralCode::from($filteredData['code']));

        if (empty($referral) || $referral->isDisabled()) {
            return Result::createError("Referral code not found", 404);
        }

        $this->referralRepository->insertReferralClickEntry($referral->getReferralId());

        return ReferralClickView::render($referral);
    }
}
