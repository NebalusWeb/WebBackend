<?php

namespace Nebalus\Webapi\Api\Referral\Service;

use Nebalus\Webapi\Api\Referral\View\ReferralDeleteView;
use Nebalus\Webapi\Api\Referral\Validator\ReferralDeleteValidator;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class ReferralDeleteService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository
    ) {
    }

    public function execute(ReferralDeleteValidator $validator): ResultInterface
    {
        return ReferralDeleteView::render();
    }
}
