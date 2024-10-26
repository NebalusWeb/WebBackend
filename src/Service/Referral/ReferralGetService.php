<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Service\Referral;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\MySqlReferralRepository;
use Nebalus\Webapi\Value\ApiResponse\ApiResponseInterface;
use Nebalus\Webapi\View\Referral\ReferralGetView;

readonly class ReferralGetService
{
    public function __construct(
        private MySqlReferralRepository $mySqlReferralRepository,
        private ReferralGetView         $referralView,
    ) {
    }

    public function action(string $code): ApiResponseInterface
    {
        if (($referral = $this->mySqlReferralRepository->getReferralByCode($code)) === false) {
            throw new ApiException("There is no referral with the code '$code' in the database", 400);
        }

        if ($referral->isEnabled()) {
            $this->mySqlReferralRepository->setViewCountByCode($referral->getCode(), $referral->getViewCount() + 1);
        }

        return $this->referralView->render($referral);
    }
}
