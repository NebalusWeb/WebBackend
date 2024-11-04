<?php

namespace Nebalus\Webapi\Api\View\User;

use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class UserRegisterView
{
    public static function render(): ResultInterface
    {
        return Result::createSuccess("User registered", 201);
    }
}
