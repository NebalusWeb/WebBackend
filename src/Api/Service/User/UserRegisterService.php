<?php

namespace Nebalus\Webapi\Api\Service\User;

use Nebalus\Webapi\Api\Validator\User\UserRegisterValidator;
use Nebalus\Webapi\Api\View\User\UserRegisterView;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\MySqlUserInvitationTokenRepository;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class UserRegisterService
{
    public function __construct(
        private MySqlUserInvitationTokenRepository $mySqlUserInvitationTokenRepository
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
            return Result::createError('Registration failed: The Invitation Token you provided already expired', 401);
        }

        return UserRegisterView::render();
    }
}
