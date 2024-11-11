<?php

namespace Nebalus\Webapi\Api\Service\Referral;

use Nebalus\Webapi\Api\Filter\Referral\ReferralCreateFilter;
use Nebalus\Webapi\Api\View\Referral\ReferralCreateView;
use Nebalus\Webapi\Repository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class ReferralCreateService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository,
        private ReferralCreateFilter $referralCreateFilter
    ) {
    }

    public function execute(array $params): ResultInterface
    {
        if ($this->referralCreateFilter->filterAndCheckIfStructureIsValid($params) === false) {
            return Result::createError($this->referralCreateFilter->getErrorMessage(), 400);
        }

        $filteredData = $this->referralCreateFilter->getFilteredData();

        return ReferralCreateView::render();
    }
}
