<?php

namespace Nebalus\Webapi\Api\User\GetUserPrivileges;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Internal\Result;

class GetUserPrivilegesView
{
    public function render(): ResultInterface
    {
        return Result::createSuccess("Here the privileges for the requested user", StatusCodeInterface::STATUS_OK, [
            "user_id" => 1,
            "privileges" => [
                "feature.referral.show_interface",
                "feature.referral.create",
            ]
        ]);
    }
}
