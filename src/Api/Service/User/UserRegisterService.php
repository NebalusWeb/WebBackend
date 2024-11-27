<?php

namespace Nebalus\Webapi\Api\Service\User;

use Nebalus\Webapi\Api\Validator\User\UserRegisterValidator;
use Nebalus\Webapi\Api\View\User\UserRegisterView;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\UserInvitationTokenRepository\MySqlUserInvitationTokenRepository;
use Nebalus\Webapi\Repository\UserRepository\MySqlUserRepository;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class UserRegisterService
{
    public function __construct(
        private readonly MySqlUserInvitationTokenRepository $mySqlUserInvitationTokenRepository,
        private readonly MySqlUserRepository $mySqlUserRepository,
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(UserRegisterValidator $validator): ResultInterface
    {
        $invitationToken = $this->mySqlUserInvitationTokenRepository->findInvitationTokenByFields($validator->getPureInvitationToken());

        if ($invitationToken === null) {
            return Result::createError('Registration failed: The Invitation Token you provided does not exist', 401);
        }

        if ($invitationToken->isExpired()) {
            return Result::createError('Registration failed: The Invitation Token you provided is already expired', 401);
        }

        $userFoundByUsername = $this->mySqlUserRepository->findUserFromUsername($validator->getUsername());

        if ($userFoundByUsername !== null) {
            return Result::createError('Registration failed: The Username you provided is already registered', 401);
        }

        $userFoundByEmail = $this->mySqlUserRepository->findUserFromEmail($validator->getUserEmail());

        if ($userFoundByEmail !== null) {
            return Result::createError('Registration failed: The Email you provided is already registered', 401);
        }



        return UserRegisterView::render();
    }
}
