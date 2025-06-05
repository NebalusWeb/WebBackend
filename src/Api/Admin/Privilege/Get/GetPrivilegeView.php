<?php

namespace Nebalus\Webapi\Api\Admin\Privilege\Get;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\Privilege;

class GetPrivilegeView
{
    public function render(Privilege $privilege): ResultInterface
    {
        $fields = [
            "id" => $privilege->getPrivilegeId()->asInt(),
            "node" => $privilege->getNode()->asString(),
            "description" => $privilege->getDescription()->asString(),
            "is_prestige" => $privilege->isPrestige(),
            "default_value" => $privilege->getDefaultValue()?->asInt(),
        ];

        return Result::createSuccess("Privilege fetched", StatusCodeInterface::STATUS_OK, $fields);
    }
}
