<?php

namespace Nebalus\Webapi\Api\View\User;

use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;
use Nebalus\Webapi\Value\User\User;
use ReallySimpleJWT\Jwt;

class UserAuthView
{
    public static function render(Jwt $jwt, User $user): ResultInterface
    {
        $fields = [
            "jwt" => $jwt->getToken(),
            "user" => [
                "user_id" => $user->getUserId()?->asInt(),
                "username" => $user->getUsername()->asString(),
                "email" => $user->getEmail()->asString(),
                "disabled" => $user->isDisabled(),
                "created_at_timestamp" => $user->getCreatedAtDate()->getTimestamp(),
            ]
        ];

        return Result::createSuccess("User successfully authenticated", 200, $fields);
    }
}
