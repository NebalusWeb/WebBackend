<?php

namespace Nebalus\Webapi\Api\Module\Referral\Edit;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Internal\Result;
use Nebalus\Webapi\Value\Module\Referral\Referral;
use Nebalus\Webapi\Value\User\User;

readonly class EditReferralService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository,
        private EditReferralView $view,
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(EditReferralValidator $validator, User $user): ResultInterface
    {
        $updatedReferral = $this->referralRepository->updateReferralFromOwner($user->getUserId(), $validator->getCode(), $validator->getUrl(), $validator->getLabel(), $validator->isDisabled());

        if ($updatedReferral instanceof Referral) {
            return $this->view->render($updatedReferral);
        }

        return Result::createError('Referral does not exist', StatusCodeInterface::STATUS_NOT_FOUND);
    }
}
