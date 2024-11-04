<?php

namespace Nebalus\Webapi\Api\Service\Referral;

use Nebalus\Webapi\Api\View\Referral\ReferralEditView;
use Nebalus\Webapi\Repository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class ReferralListallService
{
    public function __construct(
        private MySqlReferralRepository $referralRepository
    ) {
    }

    public function execute(array $params): ResultInterface
    {
        return ReferralEditView::render();
    }
}
