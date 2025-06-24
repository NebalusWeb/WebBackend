<?php

namespace Nebalus\Webapi\Api\User\GetUserPrivileges;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;

class GetUserPermissionsView
{
    public function render(): ResultInterface
    {
        return Result::createSuccess("Here the permissions for the requested user", StatusCodeInterface::STATUS_OK, [
            "user_id" => 1,
            "permissions" => [
                "feature.referral.show_interface",
                "feature.referral.create",
            ]
        ]);
    }
}
