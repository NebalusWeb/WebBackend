<?php

namespace Nebalus\Webapi\Api\Admin\Permission\GetAll;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Repository\PrivilegesRepository\MySqlPermissionRepository;
use Nebalus\Webapi\Slim\ResultInterface;

readonly class GetAllPermissionService
{
    public function __construct(
        private GetAllPermissionView $view,
        private MySqlPermissionRepository $permissionRepository
    ) {
    }

    /**
     * @throws ApiException
     */
    public function execute(): ResultInterface
    {
        $permissions = $this->permissionRepository->getAllPermissions();

        return $this->view->render($permissions);
    }
}
