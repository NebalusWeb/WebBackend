<?php

namespace Nebalus\Webapi\Api\Service\User;

use InvalidArgumentException;
use Nebalus\Webapi\Api\Filter\User\UserRegisterFilter;
use Nebalus\Webapi\Api\View\User\UserRegisterView;
use Nebalus\Webapi\Option\EnvData;
use Nebalus\Webapi\Repository\MySqlUserInvitationTokenRepository;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;
use Nebalus\Webapi\Value\User\InvitationToken\PureInvitationToken;
use Nebalus\Webapi\Value\User\UserEmail;
use Nebalus\Webapi\Value\User\UserHashedPassword;
use Nebalus\Webapi\Value\User\Username;

readonly class UserRegisterService
{
    public function __construct(
        private UserRegisterFilter $filter,
        private MySqlUserInvitationTokenRepository $mySqlUserInvitationTokenRepository,
        private EnvData $envData
    ) {
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function execute(array $params): ResultInterface
    {
        if ($this->filter->filterAndCheckIfStructureIsValid($params) === false) {
            return Result::createError($this->filter->getErrorMessage(), 401);
        }

        $filteredData = $this->filter->getFilteredData();

        try {
            $pureInvitationToken = PureInvitationToken::fromString($filteredData['invitation_token']);
            $email = UserEmail::from($filteredData['email']);
            $username = Username::from($filteredData['username']);
            $password = UserHashedPassword::from($filteredData['password'], $this->envData->getPasswdHashKey());
        } catch (InvalidArgumentException $e) {
            return Result::createError('Registration failed: PLACEHOLDER', 401);
        }

        $invitationToken = $this->mySqlUserInvitationTokenRepository->findInvitationTokenByFields($pureInvitationToken);

        if ($invitationToken === null) {
            return Result::createError('Registration failed: The Invitation Token you provided does not exist', 401);
        }

        if ($invitationToken->isExpired()) {
            return Result::createError('Registration failed: The Invitation Token you provided already expired', 401);
        }

        return UserRegisterView::render();
    }
}
