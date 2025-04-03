<?php

namespace Nebalus\Webapi\Api\Module\Linktree\Get;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;

class GetLinktreeView
{
    public function render(): ResultInterface
    {
        $fields = [];

        return Result::createSuccess("PLACEHOLDER", StatusCodeInterface::STATUS_OK, $fields);
    }
}
