<?php

namespace Nebalus\Webapi\Api\Referral\Service;

use Nebalus\Webapi\Api\Referral\View\ReferralCreateView;
use Nebalus\Webapi\Api\Referral\Validator\ReferralCreateValidator;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class ReferralCreateService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository,
    ) {
    }

    public function execute(ReferralCreateValidator $validator): ResultInterface
    {

        return ReferralCreateView::render();
    }
}
