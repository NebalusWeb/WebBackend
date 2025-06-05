<?php

namespace Nebalus\Webapi\Api\Admin\Role\Delete;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;

class DeleteRoleView
{
    public function render(): ResultInterface
    {
        return Result::createSuccess("Role deleted", StatusCodeInterface::STATUS_OK);
    }
}
