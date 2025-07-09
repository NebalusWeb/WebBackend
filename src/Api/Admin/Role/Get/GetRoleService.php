<?php

namespace Nebalus\Webapi\Api\Admin\Role\Get;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Config\Types\PermissionNodesTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Repository\RoleRepository\MySqlRoleRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccess;
use Nebalus\Webapi\Value\User\AccessControl\Permission\UserPermissionIndex;

readonly class GetRoleService
{
    public function __construct(
        private MySqlRoleRepository $roleRepository,
        private GetRoleView $view
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     * @throws ApiException
     */
    public function execute(GetRoleValidator $validator, UserPermissionIndex $userPerms): ResultInterface
    {
        if ($userPerms->hasAccessTo(PermissionAccess::from(PermissionNodesTypes::ADMIN_ROLE, true)) === false) {
            return Result::createError("You do not have enough permissions to access this resource", StatusCodeInterface::STATUS_FORBIDDEN);
        }

        $role = $this->roleRepository->findRoleById($validator->getRoleId());

        if ($role === null) {
            return Result::createError("Role not found", StatusCodeInterface::STATUS_NOT_FOUND);
        }

        if ($validator->isWithPermissions()) {
            $privileges = $this->roleRepository->getAllPermissionLinksFromRoleId($validator->getRoleId());
            return $this->view->render($role, $privileges);
        }

        return $this->view->render($role);
    }
}
