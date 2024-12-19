<?php

namespace Nebalus\Webapi\Api\Referral\Service;

use Nebalus\Webapi\Api\Referral\View\ReferralEditView;
use Nebalus\Webapi\Api\Referral\Validator\ReferralListAllValidator;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class ReferralListAllService
{
    public function __construct(
        private MySqlReferralRepository $referralRepository
    ) {
    }

    public function execute(ReferralListAllValidator $validator): ResultInterface
    {
        return ReferralEditView::render();
    }
}
