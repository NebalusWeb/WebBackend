<?php

namespace Nebalus\Webapi\Api\Referral\Get;

use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class GetReferralService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository
    ) {
    }

    public function execute(GetReferralValidator $validator): ResultInterface
    {
        return GetReferralView::render();
    }
}
