<?php

namespace Nebalus\Webapi\Api\Service\Referral;

use Nebalus\Webapi\Api\Validator\Referral\ReferralEditValidator;
use Nebalus\Webapi\Api\View\Referral\ReferralEditView;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

class ReferralEditService
{
    public function __construct(
        private readonly MySQlReferralRepository $referralRepository
    ) {
    }

    public function execute(ReferralEditValidator $validator): ResultInterface
    {
        return ReferralEditView::render();
    }
}
