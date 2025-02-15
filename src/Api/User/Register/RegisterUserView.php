<?php

namespace Nebalus\Webapi\Api\User\Register;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;
use Nebalus\Webapi\Value\User\User;

class RegisterUserView
{
    public static function render(User $user): ResultInterface
    {
        $fields = [
            "user_id" => $user->getUserId()?->asInt(),
            "username" => $user->getUsername()->asString(),
            "email" => $user->getEmail()->asString(),
            "disabled" => $user->isDisabled(),
            "created_at" => $user->getCreatedAtDate()->format(DATE_ATOM),
        ];

        return Result::createSuccess("User registered", StatusCodeInterface::STATUS_CREATED, $fields);
    }
}
