<?php

namespace Nebalus\Webapi\Api\Module\Referral\Get;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Internal\Result;
use Nebalus\Webapi\Value\User\User;

readonly class GetReferralService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository,
        private GetReferralView $view,
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(GetReferralValidator $validator, User $user): ResultInterface
    {
        $referral = $this->referralRepository->findReferralByCodeFromOwner($user->getUserId(), $validator->getReferralCode());

        if ($referral === null) {
            return Result::createError('Referral not found', StatusCodeInterface::STATUS_NOT_FOUND);
        }

        return $this->view->render($referral);
    }
}
