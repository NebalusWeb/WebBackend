<?php

namespace Nebalus\Webapi\Api\User\GetUserPermissions;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\RoleRepository\MySqlRoleRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\AccessControl\Permission\UserPermissionIndex;
use Nebalus\Webapi\Value\User\User;

readonly class GetUserPermissionsService
{
    public function __construct(
        private GetUserPermissionsView $view,
        private MySqlRoleRepository $roleRepository
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(GetUserPermissionsValidator $validator, User $requestingUser, UserPermissionIndex $userPermissionIndex): ResultInterface
    {
        $userId = $validator->getUserId();

        if ($userId === null) {
            return $this->view->render($requestingUser->getUserId(), $userPermissionIndex);
        }

        $otherUserPermissionIndex = $this->roleRepository->getPermissionIndexFromUserId($userId);
        return $this->view->render($userId, $otherUserPermissionIndex);
    }
}
