<?php

namespace Nebalus\Webapi\Api\Admin\Role\Get;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Slim\ResultInterface;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionRoleLinkCollection;
use Nebalus\Webapi\Value\User\AccessControl\Role\Role;

class GetRoleView
{
    public function render(Role $role, ?PermissionRoleLinkCollection $permissionRoleLinkCollection = null): ResultInterface
    {
        $fields = [
            'role_id' => $role->getRoleId()->asInt(),
            'name' => $role->getName()->asString(),
            'description' => $role->getDescription()?->asString(),
            'color' => $role->getColor()->asString(),
            'access_level' => $role->getAccessLevel()->asInt(),
            'applies_to_everyone' => $role->appliesToEveryone(),
            'deletable' => $role->isDeletable(),
            'editable' => $role->isEditable(),
            'disabled' => $role->isDisabled(),
            "created_at" => $role->getCreatedAtDate()->format(DATE_ATOM),
            "updated_at" => $role->getUpdatedAtDate()->format(DATE_ATOM),
        ];

        if ($permissionRoleLinkCollection !== null) {
            $permissions = [];

            foreach ($permissionRoleLinkCollection as $permissionRoleLink) {
                $permissions[] = [
                    "node" => $permissionRoleLink->getNode()->asString(),
                    "allow_all_sub_permissions" => $permissionRoleLink->getMetadata()->allowAllSubPermissions(),
                    "value" => $permissionRoleLink->getMetadata()->getValue()?->asInt(),
                ];
            }

            $fields["permissions"] = $permissions;
        }

        return Result::createSuccess("Role Fetched", StatusCodeInterface::STATUS_OK, $fields);
    }
}
