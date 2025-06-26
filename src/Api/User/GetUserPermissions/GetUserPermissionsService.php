<?php

namespace Nebalus\Webapi\Api\User\GetUserPermissions;

use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\User\AccessControl\Permission\UserPermissionIndex;
use Nebalus\Webapi\Value\User\User;

readonly class GetUserPermissionsService
{
    public function __construct(
        private GetUserPermissionsView $view,
    ) {
    }

    public function execute(GetUserPermissionsValidator $validator, User $requestingUser, UserPermissionIndex $userPermissionIndex): ResultInterface
    {
        return $this->view->render();
    }
}
