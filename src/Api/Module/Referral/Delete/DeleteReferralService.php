<?php

namespace Nebalus\Webapi\Api\Module\Referral\Delete;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\User;

readonly class DeleteReferralService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository,
        private DeleteReferralView $view,
    ) {
    }

    public function execute(DeleteReferralValidator $validator, User $requestingUser): ResultInterface
    {
        if ($this->referralRepository->deleteReferralByCodeFromOwner($requestingUser->getUserId(), $validator->getReferralCode())) {
            return $this->view->render();
        }

        return Result::createError('Referral does not exist', StatusCodeInterface::STATUS_NOT_FOUND);
    }
}
