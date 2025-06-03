<?php

namespace Nebalus\Webapi\Api\Admin\Role\Delete;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;

class DeleteRoleView
{
    public function render(): ResultInterface
    {
        return Result::createSuccess("Role deleted", StatusCodeInterface::STATUS_OK);
    }
}
