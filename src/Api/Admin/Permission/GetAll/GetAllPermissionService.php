<?php

namespace Nebalus\Webapi\Api\Admin\Permission\GetAll;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Config\Types\PermissionNodesTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\PermissionsRepository\MySqlPermissionRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccess;
use Nebalus\Webapi\Value\User\AccessControl\Permission\UserPermissionIndex;

readonly class GetAllPermissionService
{
    public function __construct(
        private GetAllPermissionResponder $view,
        private MySqlPermissionRepository $permissionRepository
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

        $requestedPermissions = $this->permissionRepository->getAllPermissions();

        return $this->view->render($requestedPermissions);
    }
}
