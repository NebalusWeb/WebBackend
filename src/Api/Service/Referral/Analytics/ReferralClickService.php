<?php

namespace Nebalus\Webapi\Api\Service\Referral\Analytics;

use Nebalus\Webapi\Api\Filter\Referral\Analytics\ReferralClickFilter;
use Nebalus\Webapi\Api\View\Referral\Analytics\ReferralClickView;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Referral\ReferralCode;
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
    public function execute(array $params): ResultInterface
    {
        $referral = $this->referralRepository->findReferralByCode(ReferralCode::from($filteredData['code']));

        if (empty($referral) || $referral->isDisabled()) {
            return Result::createError("Referral code not found", 404);
        }

        $this->referralRepository->insertReferralClickEntry($referral->getReferralId());

        return ReferralClickView::render($referral);
    }
}
