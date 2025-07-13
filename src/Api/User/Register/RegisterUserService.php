<?php

namespace Nebalus\Webapi\Api\User\Register;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\AccountRepository\MySqlAccountRepository;
use Nebalus\Webapi\Repository\UserRepository\MySqlUserRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\User;

readonly class RegisterUserService
{
    public function __construct(
        private MySqlUserRepository $mySqlUserRepository,
        private MySqlAccountRepository $mySqlAccountRepository,
        private RegisterUserResponder $responder,
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(RegisterUserValidator $validator): ResultInterface
    {
        $invitationToken = $this->mySqlAccountRepository->findInvitationTokenByFields($validator->getPureInvitationToken());

        if ($invitationToken === null) {
            return Result::createError('Registration failed: The Invitation Token you provided does not exist', StatusCodeInterface::STATUS_FORBIDDEN);
        }

        if ($invitationToken->isExpired()) {
            return Result::createError('Registration failed: The Invitation Token you provided is expired', StatusCodeInterface::STATUS_FORBIDDEN);
        }

        $userFoundByUsername = $this->mySqlUserRepository->findUserFromUsername($validator->getUsername());

        if ($userFoundByUsername !== null) {
            return Result::createError('Registration failed: The Username you provided is already registered', StatusCodeInterface::STATUS_FORBIDDEN);
        }

        $userFoundByEmail = $this->mySqlUserRepository->findUserFromEmail($validator->getUserEmail());

        if ($userFoundByEmail !== null) {
            return Result::createError('Registration failed: The Email you provided is already registered', StatusCodeInterface::STATUS_FORBIDDEN);
        }

        $preUser = User::create($validator->getUsername(), $validator->getUserEmail(), $validator->getUserPassword());

        $this->mySqlUserRepository->registerUser($preUser, $invitationToken);

        return $this->responder->render();
    }
}
