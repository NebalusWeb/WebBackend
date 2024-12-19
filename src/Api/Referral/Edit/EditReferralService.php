<?php

namespace Nebalus\Webapi\Api\Referral\Edit;

use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class EditReferralService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository
    ) {
    }

    public function execute(EditReferralValidator $validator): ResultInterface
    {
        return EditReferralView::render();
    }
}
