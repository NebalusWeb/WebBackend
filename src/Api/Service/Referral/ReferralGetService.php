<?php

namespace Nebalus\Webapi\Api\Service\Referral;

use Nebalus\Webapi\Api\View\Referral\ReferralGetView;
use Nebalus\Webapi\Repository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class ReferralGetService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository
    ) {
    }

    public function execute(array $params): ResultInterface
    {
        return ReferralGetView::render();
    }
}
