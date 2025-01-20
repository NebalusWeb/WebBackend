<?php

namespace Nebalus\Webapi\Api\Module\Referral\Analytics\ClickHistory;

use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Account\User\User;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;

readonly class ClickHistoryReferralService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository
    ) {
    }


    public function execute(ClickHistoryReferralValidator $validator, User $user): ResultInterface
    {
        $data = $this->referralRepository->getReferralClicksFromRange($user->getUserId(), $validator->getReferralCode(), $validator->getRange());

        return ClickHistoryReferralView::render($data);
    }
}
