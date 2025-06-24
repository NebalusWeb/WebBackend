<?php

namespace Nebalus\Webapi\Api\Admin\Privilege\GetAll;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeCollection;

class GetAllPrivilegeView
{

    public function render(PrivilegeCollection $privilegeCollection): ResultInterface
    {
        $fields = [];
        foreach ($privilegeCollection as $privilege) {
            $fields[] = [
                "privilege_id" => $privilege->getPrivilegeId()->asInt(),
                "node" => $privilege->getNode()->asString(),
                "description" => $privilege->getDescription()->asString(),
                "is_prestige" => $privilege->isPrestige(),
                "default_value" => $privilege->getDefaultValue()?->asInt(),
            ];
        }

        return Result::createSuccess("List of privileges found", StatusCodeInterface::STATUS_OK, $fields);
    }
}
