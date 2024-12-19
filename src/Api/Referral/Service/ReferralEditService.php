<?php

namespace Nebalus\Webapi\Api\Referral\Service;

use Nebalus\Webapi\Api\Referral\View\ReferralEditView;
use Nebalus\Webapi\Api\Referral\Validator\ReferralEditValidator;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class ReferralEditService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository
    ) {
    }

    public function execute(ReferralEditValidator $validator): ResultInterface
    {
        return ReferralEditView::render();
    }
}
