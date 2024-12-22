<?php

namespace Nebalus\Webapi\Api\Module\Referral\GetAll;

use Nebalus\Webapi\Api\Module\Referral\Edit\EditReferralView;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;
use Nebalus\Webapi\Value\User\User;
use Nebalus\Webapi\Value\User\UserId;

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
        $referrals = $this->referralRepository->getReferralsFromOwnerId($user->getUserId());
        return GetAllReferralView::render($referrals);
    }
}
