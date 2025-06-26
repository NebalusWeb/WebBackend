<?php

namespace Nebalus\Webapi\Api\Module\Referral\GetAll;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\User\User;

readonly class GetAllReferralService
{
    public function __construct(
        private MySqlReferralRepository $referralRepository,
        private GetAllReferralView $view,
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(User $requestingUser): ResultInterface
    {
        $referrals = $this->referralRepository->getReferralsFromOwner($requestingUser->getUserId());
        return $this->view->render($referrals);
    }
}
