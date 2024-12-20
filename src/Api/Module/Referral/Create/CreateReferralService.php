<?php

namespace Nebalus\Webapi\Api\Module\Referral\Create;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Value\Referral\ReferralCode;
use Nebalus\Webapi\Value\Result\ResultInterface;
use Nebalus\Webapi\Value\User\UserId;

readonly class CreateReferralService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository,
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(CreateReferralValidator $validator): ResultInterface
    {
        $referralCode = ReferralCode::create();

        $this->referralRepository->insertReferral(UserId::from(1), $referralCode, $validator->getReferralPointer(), $validator->getReferralName(), $validator->isDisabled());
        $referral = $this->referralRepository->findReferralByCode($referralCode);

        return CreateReferralView::render($referral);
    }
}
