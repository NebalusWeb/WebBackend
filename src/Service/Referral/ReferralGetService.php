<?php

namespace Nebalus\Webapi\Service\Referral;

use Exception;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\MySqlReferralRepository;
use Nebalus\Webapi\ValueObject\Referral\ReferralObject;

class ReferralGetService
{
    private MySqlReferralRepository $mySqlReferralRepository;
    public function __construct(
        MySqlReferralRepository $mySqlReferralRepository,
    ) {
        $this->mySqlReferralRepository = $mySqlReferralRepository;
    }

    public function action(string $code): ReferralObject
    {
        if (($referral = $this->mySqlReferralRepository->getReferralByCode($code)) === false) {
            throw new ApiException("There is no referral with the code '$code' in the database", 400);
        }
        /*
        if ($referral->isEnabled()) {
            $this->mySqlReferralRepository->setViewCountByCode($referral->getCode(), $referral->getViewCount() + 1);
        }
        */

        return $referral;
    }
}
