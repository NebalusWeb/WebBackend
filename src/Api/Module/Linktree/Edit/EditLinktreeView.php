<?php

namespace Nebalus\Webapi\Api\Module\Linktree\Edit;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;

class EditLinktreeView
{
    public function render(): ResultInterface
    {
        $fields = [];

        return Result::createSuccess("PLACEHOLDER", StatusCodeInterface::STATUS_OK, $fields);
    }
}
