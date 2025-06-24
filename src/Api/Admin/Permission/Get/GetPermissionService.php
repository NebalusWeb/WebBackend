<?php

namespace Nebalus\Webapi\Api\Admin\Permission\Get;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Repository\PrivilegesRepository\MySqlPermissionRepository;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;

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
    public function execute(GetPermissionValidator $validator): ResultInterface
    {
        $permission = $this->permissionRepository->findPermissionByPermissionId($validator->getPermissionId());

        if ($permission === null) {
            return Result::createError("Permission not found", StatusCodeInterface::STATUS_NOT_FOUND);
        }

        return $this->view->render($permission);
    }
}
