<?php

namespace Nebalus\Webapi\Api\Admin\Permission\Get;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Config\Types\PermissionNodesTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Repository\PermissionsRepository\MySqlPermissionRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccess;
use Nebalus\Webapi\Value\User\AccessControl\Permission\UserPermissionIndex;

readonly class GetPermissionService
{
    public function __construct(
        private MySqlPermissionRepository $permissionRepository,
        private GetPermissionView $view
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException
     * @throws ApiException
     */
    public function execute(GetPermissionValidator $validator, UserPermissionIndex $userPermissionIndex): ResultInterface
    {
        if ($userPermissionIndex->hasAccessTo(PermissionAccess::from(PermissionNodesTypes::ADMIN_ROLE, true)) === false) {
            return Result::createError("You do not have enough permissions to access this resource", StatusCodeInterface::STATUS_FORBIDDEN);
        }

        $permission = $this->permissionRepository->findPermissionByPermissionId($validator->getPermissionId());

        if ($permission === null) {
            return Result::createError("Permission not found", StatusCodeInterface::STATUS_NOT_FOUND);
        }

        return $this->view->render($permission);
    }
}
