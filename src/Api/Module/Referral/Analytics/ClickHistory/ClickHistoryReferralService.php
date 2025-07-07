<?php

namespace Nebalus\Webapi\Api\Module\Referral\Analytics\ClickHistory;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Config\Types\PermissionNodesTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\ReferralRepository\MySqlReferralRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccess;
use Nebalus\Webapi\Value\User\AccessControl\Permission\UserPermissionIndex;
use Nebalus\Webapi\Value\User\User;

readonly class ClickHistoryReferralService
{
    public function __construct(
        private MySQlReferralRepository $referralRepository,
        private ClickHistoryReferralView $view,
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(ClickHistoryReferralValidator $validator, User $requestingUser, UserPermissionIndex $userPermissionIndex): ResultInterface
    {
        if (($validator->getUserId() === null || $validator->getUserId() === $requestingUser->getUserId()) && $userPermissionIndex->hasAccessTo(PermissionAccess::from(PermissionNodesTypes::FEATURE_REFERRAL_OWN, true))) {
            $referral = $this->referralRepository->findReferralByCodeFromOwner($requestingUser->getUserId(), $validator->getReferralCode());
            if ($referral === null) {
                return Result::createError("Referral not found");
            }
            $data = $this->referralRepository->getReferralClicksFromRange($requestingUser->getUserId(), $validator->getReferralCode(), $validator->getRange());
            return $this->view->render($validator->getReferralCode(), $data);
        }

        if ($userPermissionIndex->hasAccessTo(PermissionAccess::from(PermissionNodesTypes::FEATURE_REFERRAL_OTHER, true))) {
            $referral = $this->referralRepository->findReferralByCodeFromOwner($validator->getUserId(), $validator->getReferralCode());
            if ($referral === null) {
                return Result::createError("Referral not found");
            }
            $data = $this->referralRepository->getReferralClicksFromRange($validator->getUserId(), $validator->getReferralCode(), $validator->getRange());
            return $this->view->render($validator->getReferralCode(), $data);
        }

        return Result::createError("Not enough permissions", StatusCodeInterface::STATUS_NOT_ACCEPTABLE);
    }
}
