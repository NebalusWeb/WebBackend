<?php

namespace Nebalus\Webapi\Api\Admin\Role\GetAll;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleCollection;

class GetAllRoleView
{
    public function render(RoleCollection $roleCollection): ResultInterface
    {
        $fields = [];
        foreach ($roleCollection as $role) {
            $fields[] = [
                'id' => $role->getRoleId()->asInt(),
                'name' => $role->getName()->asString(),
                'description' => $role->getDescription()?->asString(),
                'applies_to_everyone' => $role->appliesToEveryone(),
                'deletable' => $role->isDeletable(),
                'editable' => $role->isEditable(),
                'access_level' => $role->getAccessLevel()->asInt(),
                "created_at" => $role->getCreatedAtDate()->format(DATE_ATOM),
                "updated_at" => $role->getUpdatedAtDate()->format(DATE_ATOM),
            ];
        }
        return Result::createSuccess("List of all roles", StatusCodeInterface::STATUS_OK, $fields);
    }
}
