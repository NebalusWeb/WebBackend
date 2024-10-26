<?php

namespace Nebalus\Webapi\View\Auth;

use Nebalus\Webapi\Value\ApiResponse\ApiResponse;
use Nebalus\Webapi\Value\ApiResponse\ApiResponseInterface;
use Nebalus\Webapi\Value\User\User;
use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Token;

class AuthView
{
    public static function render(Jwt $jwt, User $user): ApiResponseInterface
    {
        $payload = [
            "jwt" => $jwt->getToken(),
            "user" => [
                "user_id" => $user->getUserId()->asInt(),
                "username" => $user->getUsername()->asString(),
                "email" => $user->getEmail()->asString(),
                "is_admin" => $user->isAdmin(),
                "is_enabled" => $user->isEnabled(),
                "creation_date_timestamp" => $user->getCreationDate()->getTimestamp()
            ]
        ];

        return ApiResponse::createSuccess($payload, 200);
    }
}
