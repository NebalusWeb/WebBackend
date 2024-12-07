<?php

namespace Nebalus\Webapi\Api\Service\User;

use Nebalus\Webapi\Api\Validator\User\UserRegisterValidator;
use Nebalus\Webapi\Api\View\User\UserRegisterView;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\AccountRepository\MySqlAccountRepository;
use Nebalus\Webapi\Repository\UserRepository\MySqlUserRepository;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;
use Nebalus\Webapi\Value\User\User;

readonly class UserRegisterService
{
    public function __construct(
        private MySqlUserRepository $mySqlUserRepository,
        private MySqlAccountRepository $mySqlAccountRepository,
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(UserRegisterValidator $validator): ResultInterface
    {
        $invitationToken = $this->mySqlAccountRepository->findInvitationTokenByFields($validator->getPureInvitationToken());

        if ($invitationToken === null) {
            return Result::createError('Registration failed: The Invitation Token you provided does not exist', 403);
        }

        if ($invitationToken->isExpired()) {
            return Result::createError('Registration failed: The Invitation Token you provided is already expired', 403);
        }

        $userFoundByUsername = $this->mySqlUserRepository->findUserFromUsername($validator->getUsername());

        if ($userFoundByUsername !== null) {
            return Result::createError('Registration failed: The Username you provided is already registered', 403);
        }

        $userFoundByEmail = $this->mySqlUserRepository->findUserFromEmail($validator->getUserEmail());

        if ($userFoundByEmail !== null) {
            return Result::createError('Registration failed: The Email you provided is already registered', 403);
        }

        $preUser = User::create($validator->getUsername(), $validator->getUserEmail(), $validator->getUserPassword());

        $createdUser = $this->mySqlUserRepository->registerUser($preUser, $invitationToken);

        return UserRegisterView::render($createdUser);
    }
}
