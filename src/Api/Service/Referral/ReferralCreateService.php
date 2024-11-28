<?php

namespace Nebalus\Webapi\Api\Service\Referral;

use Nebalus\Webapi\Api\Validator\Referral\ReferralCreateValidator;
use Nebalus\Webapi\Api\View\Referral\ReferralCreateView;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

class ReferralCreateService
{
    public function __construct(
        private readonly MySQlReferralRepository $referralRepository,
    ) {
    }

    public function execute(ReferralCreateValidator $validator): ResultInterface
    {

        return ReferralCreateView::render();
    }
}
