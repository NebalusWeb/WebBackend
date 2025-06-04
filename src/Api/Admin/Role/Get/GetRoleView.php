<?php

namespace Nebalus\Webapi\Api\Admin\Role\Get;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeRoleLinkCollection;
use Nebalus\Webapi\Value\User\AccessControl\Role\Role;

class GetRoleView
{
    public function render(Role $role, PrivilegeRoleLinkCollection $privilegeNodeCollection, bool $withPrivileges): ResultInterface
    {
        $fields = [
            'id' => $role->getRoleId()->asInt(),
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

        if ($withPrivileges) {
            $privileges = [];

            foreach ($privilegeNodeCollection as $privilegeNode) {
                $privileges[] = [
                    'id' => $privilegeNode->getRoleId()->asInt(),

                ];
            }

            $fields["privileges"] = $privileges;
        }

        return Result::createSuccess("Role fetched", StatusCodeInterface::STATUS_OK, $fields);
    }
}
