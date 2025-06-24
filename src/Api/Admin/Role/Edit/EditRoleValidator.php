<?php

namespace Nebalus\Webapi\Api\Admin\Role\Edit;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Api\RequestParamTypes;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionNode;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionRoleLink;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionRoleLinkCollection;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionValue;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleAccessLevel;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleDescription;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleHexColor;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleId;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleName;

class EditRoleValidator extends AbstractValidator
{
    private RoleId $roleId;
    private RoleName $roleName;
    private ?RoleDescription $roleDescription;
    private RoleHexColor $roleColor;
    private RoleAccessLevel $accessLevel;
    private bool $appliesToEveryone;
    private PermissionRoleLinkCollection $permissionRoleLinks;

    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::PATH_ARGS => S::object([
                "roleId" => RoleId::getSchema(),
            ]),
            RequestParamTypes::BODY => S::object([
                "name" => RoleName::getSchema(),
                "description" => RoleDescription::getSchema()->nullable()->optional(),
                "color" => RoleHexColor::getSchema(),
                "access_level" => RoleAccessLevel::getSchema(),
                "applies_to_everyone" => S::boolean(),
                "disabled" => S::boolean(),
                "permissions" => S::array(S::object([
                    "node" => PermissionNode::getSchema(),
                    "value" => PermissionNode::getSchema()->optional()->nullable()->default(null),
                    "affects_all_sub_permissions" => S::boolean(),
                    "is_blacklisted" => S::boolean(),
                ])),
            ])
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->roleId = RoleId::from($pathArgsData["roleId"]);
        $this->roleName = RoleName::from($bodyData["name"]);
        $this->roleDescription = isset($bodyData["description"]) ? RoleDescription::from($bodyData["description"]) : null;
        $this->roleColor = RoleHexColor::from($bodyData["color"]);
        $this->accessLevel = RoleAccessLevel::from($bodyData["access_level"]);
        $this->appliesToEveryone = $bodyData["applies_to_everyone"];
        $this->permissionRoleLinks = PermissionRoleLinkCollection::fromObjects(
            ...array_map(
                fn(array $permission) => PermissionRoleLink::from(
                    PermissionNode::from($permission["node"]),
                    $permission["affects_all_sub_permissions"],
                    $permission["is_blacklisted"],
                    isset($permission["value"]) ? PermissionValue::from($permission["value"]) : null
                ),
                $bodyData["permissions"]
            )
        );
    }

    public function getRoleId(): RoleId
    {
        return $this->roleId;
    }

    public function getRoleName(): RoleName
    {
        return $this->roleName;
    }

    public function getRoleDescription(): ?RoleDescription
    {
        return $this->roleDescription;
    }

    public function getRoleColor(): RoleHexColor
    {
        return $this->roleColor;
    }

    public function getAccessLevel(): RoleAccessLevel
    {
        return $this->accessLevel;
    }

    public function appliesToEveryone(): bool
    {
        return $this->appliesToEveryone;
    }

    public function getPermissionRoleLinks(): PermissionRoleLinkCollection
    {
        return $this->permissionRoleLinks;
    }
}
