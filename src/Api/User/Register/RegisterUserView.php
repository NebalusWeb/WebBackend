<?php

namespace Nebalus\Webapi\Api\User\Register;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;

class RegisterUserView
{
    public static function render(): ResultInterface
    {
        return Result::createSuccess("User registered", StatusCodeInterface::STATUS_CREATED, []);
    }
}
