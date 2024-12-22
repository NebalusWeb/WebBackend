<?php

namespace Nebalus\Webapi\Api\Module\Linktree\Delete;

use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class DeleteLinktreeView
{
    public static function render(): ResultInterface
    {
        $fields = [];

        return Result::createSuccess("PLACEHOLDER", 200, $fields);
    }
}
