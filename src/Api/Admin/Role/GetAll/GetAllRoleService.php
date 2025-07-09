<?php

namespace Nebalus\Webapi\Api\Admin\Role\GetAll;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Config\Types\PermissionNodesTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\RoleRepository\MySqlRoleRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccess;
use Nebalus\Webapi\Value\User\AccessControl\Permission\UserPermissionIndex;

readonly class GetAllRoleService
{
    public function __construct(
        private GetAllRoleResponder $view,
        private MySqlRoleRepository $roleRepository
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(UserPermissionIndex $userPerms): ResultInterface
    {
        if ($userPerms->hasAccessTo(PermissionAccess::from(PermissionNodesTypes::ADMIN_ROLE, true)) === false) {
            return Result::createError("You do not have enough permissions to access this resource", StatusCodeInterface::STATUS_FORBIDDEN);
        }

        $roles = $this->roleRepository->getAllRoles();

        return $this->view->render($roles);
    }
}
