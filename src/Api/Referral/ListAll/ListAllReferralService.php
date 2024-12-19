<?php

namespace Nebalus\Webapi\Api\Referral\ListAll;

use Nebalus\Webapi\Api\Referral\Edit\EditReferralView;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class ListAllReferralService
{
    public function __construct(
        private MySqlReferralRepository $referralRepository
    ) {
    }

    public function execute(ListAllReferralValidator $validator): ResultInterface
    {
        return EditReferralView::render();
    }
}
