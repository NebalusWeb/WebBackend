<?php

namespace Nebalus\Webapi\Api\User\GetUserPrivileges;

use Nebalus\Webapi\Slim\ResultInterface;

class GetUserPrivilegesService
{

    public function __construct(
        private GetUserPrivilegesView $view,
    ) {
    }

    public function execute(GetUserPrivilegesValidator $validator): ResultInterface
    {
        return $this->view->render();
    }
}
