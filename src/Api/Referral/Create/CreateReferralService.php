<?php

namespace Nebalus\Webapi\Api\Referral\Create;

use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class CreateReferralService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository,
    ) {
    }

    public function execute(CreateReferralValidator $validator): ResultInterface
    {

        return CreateReferralView::render();
    }
}
