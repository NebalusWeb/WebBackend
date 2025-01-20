<?php

namespace Nebalus\Webapi\Api\User\Register;

use Nebalus\Webapi\Value\Account\User\User;
use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;

class RegisterUserView
{
    public static function render(User $user): ResultInterface
    {
        $fields = [
            "user_id" => $user->getUserId()?->asInt(),
            "username" => $user->getUsername()->asString(),
            "email" => $user->getEmail()->asString(),
            "disabled" => $user->isDisabled(),
            "created_at_timestamp" => $user->getCreatedAtDate()->getTimestamp(),
        ];

        return Result::createSuccess("User registered", 201, $fields);
    }
}
