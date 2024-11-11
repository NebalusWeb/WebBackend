<?php

namespace Nebalus\Webapi\Api\Service\Referral;

use Nebalus\Webapi\Api\View\Referral\ReferralDeleteView;
use Nebalus\Webapi\Repository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class ReferralDeleteService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository
    ) {
    }

    public function execute(array $params): ResultInterface
    {
        return ReferralDeleteView::render();
    }
}
