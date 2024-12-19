<?php

namespace Nebalus\Webapi\Api\Referral\GetAll;

use Nebalus\Webapi\Api\Referral\Edit\EditReferralView;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class GetAllReferralService
{
    public function __construct(
        private MySqlReferralRepository $referralRepository
    ) {
    }

    public function execute(GetAllReferralValidator $validator): ResultInterface
    {
        return EditReferralView::render();
    }
}
