<?php

namespace Nebalus\Webapi\Api\User\GetUserPrivileges;

use Nebalus\Webapi\Slim\ResultInterface;

readonly class GetUserPermissionsService
{
    public function __construct(
        private GetUserPermissionsView $view,
    ) {
    }

    public function execute(GetUserPermissionsValidator $validator): ResultInterface
    {
        return $this->view->render();
    }
}
