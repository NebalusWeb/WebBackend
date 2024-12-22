<?php

namespace Nebalus\Webapi\Api\Module\Linktree\Create;

use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class CreateLinktreeView
{
    public static function render(): ResultInterface
    {
        $fields = [];

        return Result::createSuccess("PLACEHOLDER", 200, $fields);
    }
}
