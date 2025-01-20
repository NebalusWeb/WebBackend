<?php

namespace Nebalus\Webapi\Api\Module\Referral\GetAll;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Account\User\User;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;

readonly class GetAllReferralService
{
    public function __construct(
        private MySqlReferralRepository $referralRepository
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(User $user): ResultInterface
    {
        $referrals = $this->referralRepository->getReferralsFromOwner($user->getUserId());
        return GetAllReferralView::render($referrals);
    }
}
