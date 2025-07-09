<?php

namespace Nebalus\Webapi\Api\User\GetUserPermissions;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\RoleRepository\MySqlRoleRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\User\AccessControl\Permission\UserPermissionIndex;
use Nebalus\Webapi\Value\User\User;

readonly class GetUserPermissionsService
{
    public function __construct(
        private GetUserPermissionsResponder $responder,
        private MySqlRoleRepository $roleRepository
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(GetUserPermissionsValidator $validator, User $requestingUser, UserPermissionIndex $userPermissionIndex): ResultInterface
    {
        $userId = $validator->getUserId();

        if ($userId === null || $userId === $requestingUser->getUserId()) {
            return $this->responder->render($requestingUser->getUserId(), $userPermissionIndex);
        }

        $otherUserPermissionIndex = $this->roleRepository->getPermissionIndexFromUserId($userId);
        return $this->responder->render($userId, $otherUserPermissionIndex);
    }
}
