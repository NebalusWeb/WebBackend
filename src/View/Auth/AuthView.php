<?php

namespace Nebalus\Webapi\View\Auth;

use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponse;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponseInterface;

class AuthView
{
    public static function render(): ApiResponseInterface
    {
        $payload = [
            "test" => 1
        ];

        return ApiResponse::createSuccess($payload, 200);
    }
}
