<?php

namespace Nebalus\Webapi\Api\Service\User;

use InvalidArgumentException;
use Nebalus\Webapi\Api\Filter\User\UserRegisterFilter;
use Nebalus\Webapi\Api\View\User\UserRegisterView;
use Nebalus\Webapi\Option\EnvData;
use Nebalus\Webapi\Repository\MySqlUserRepository;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;
use Nebalus\Webapi\Value\User\InvitationToken\InvitationToken;
use Nebalus\Webapi\Value\User\InvitationToken\PureInvitationToken;

readonly class UserRegisterService
{
    public function __construct(
        private UserRegisterFilter $filter,
        private MySqlUserRepository $mySqlUserRepository,
        private EnvData $envData
    ) {
    }

    public function execute(array $params): ResultInterface
    {
        if ($this->filter->filterAndCheckIfStructureIsValid($params) === false) {
            return Result::createError($this->filter->getErrorMessage(), 401);
        }

        $filteredData = $this->filter->getFilteredData();

        try {
            $invitationToken = PureInvitationToken::fromString($filteredData['invitation_token']);
        } catch (InvalidArgumentException $e) {
            return Result::createError('Registration failed: sd', 401);
        }


        return UserRegisterView::render();
    }
}
