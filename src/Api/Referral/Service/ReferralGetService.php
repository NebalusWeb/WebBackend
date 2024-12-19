<?php

namespace Nebalus\Webapi\Api\Referral\Service;

use Nebalus\Webapi\Api\Referral\View\ReferralGetView;
use Nebalus\Webapi\Api\Referral\Validator\ReferralGetValidator;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class ReferralGetService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository
    ) {
    }

    public function execute(ReferralGetValidator $validator): ResultInterface
    {
        return ReferralGetView::render();
    }
}
