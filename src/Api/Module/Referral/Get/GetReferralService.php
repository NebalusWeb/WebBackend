<?php

namespace Nebalus\Webapi\Api\Module\Referral\Get;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class GetReferralService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(GetReferralValidator $validator): ResultInterface
    {
        $referral = $this->referralRepository->findReferralByCode($validator->getReferralCode());

        if ($referral === null) {
            return Result::createError('Referral does not exist', 404);
        }

        return GetReferralView::render($referral);
    }
}
