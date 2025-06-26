<?php

namespace Nebalus\Webapi\Api\Module\Referral\Analytics\ClickHistory;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\User\User;

readonly class ClickHistoryReferralService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository,
        private ClickHistoryReferralView $view,
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(ClickHistoryReferralValidator $validator, User $requestingUser): ResultInterface
    {
        $data = $this->referralRepository->getReferralClicksFromRange($requestingUser->getUserId(), $validator->getReferralCode(), $validator->getRange());
        return $this->view->render($validator->getReferralCode(), $data);
    }
}
