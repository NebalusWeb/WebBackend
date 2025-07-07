<?php

namespace Nebalus\Webapi\Api\Admin\Role\Create;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Config\Types\PermissionNodesTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\RoleRepository\MySqlRoleRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccess;
use Nebalus\Webapi\Value\User\AccessControl\Permission\UserPermissionIndex;
use Nebalus\Webapi\Value\User\AccessControl\Role\Role;
use Nebalus\Webapi\Value\User\User;

readonly class CreateRoleService
{
    public function __construct(
        private MySqlRoleRepository $roleRepository,
        private CreateRoleView $view,
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(CreateRoleValidator $validator, UserPermissionIndex $userPerms): ResultInterface
    {
        if ($userPerms->hasAccessTo(PermissionAccess::from(PermissionNodesTypes::ADMIN_ROLE_CREATE, true)) === false) {
            return Result::createError("You do not have enough permissions to access this resource", StatusCodeInterface::STATUS_FORBIDDEN);
        }

        $role = Role::create($validator->getRoleName(), $validator->getRoleDescription(), $validator->getRoleColor(), $validator->getAccessLevel(), $validator->appliesToEveryone(), $validator->isDisabled());
        $role = $this->roleRepository->insertRole($role);

        return $this->view->render($role);
    }
}
