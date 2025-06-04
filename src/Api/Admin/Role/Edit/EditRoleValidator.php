<?php

namespace Nebalus\Webapi\Api\Admin\Role\Edit;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Api\RequestParamTypes;
use Nebalus\Webapi\Value\HexColor;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\Entity\PrivilegeRoleLink;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\Entity\PrivilegeRoleLinkCollection;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNode;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeValue;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleAccessLevel;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleDescription;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleId;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleName;

class EditRoleValidator extends AbstractValidator
{
    private RoleId $roleId;
    private RoleName $roleName;
    private ?RoleDescription $roleDescription;
    private HexColor $roleColor;
    private RoleAccessLevel $accessLevel;
    private bool $appliesToEveryone;
    private PrivilegeRoleLinkCollection $privilegeRoleLinks;

    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::PATH_ARGS => S::object([
                "roleId" => RoleId::getSchema(),
            ]),
            RequestParamTypes::BODY => S::object([
                "name" => RoleName::getSchema(),
                "description" => RoleDescription::getSchema()->nullable()->optional(),
                "color" => HexColor::getSchema(),
                "access_level" => RoleAccessLevel::getSchema(),
                "applies_to_everyone" => S::boolean(),
                "privileges" => S::array(S::object([
                    "node" => PrivilegeNode::getSchema(),
                    "value" => PrivilegeValue::getSchema()->optional()->nullable()->default(null),
                    "affects_all_sub_privileges" => S::boolean(),
                    "is_blacklisted" => S::boolean(),
                ]))->optional()->nullable()->default([]),
            ])
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->roleId = RoleId::from($pathArgsData["roleId"]);
        $this->roleName = RoleName::from($bodyData["name"]);
        $this->roleDescription = isset($bodyData["description"]) ? RoleDescription::from($bodyData["description"]) : null;
        $this->roleColor = HexColor::from($bodyData["color"]);
        $this->accessLevel = RoleAccessLevel::from($bodyData["access_level"]);
        $this->appliesToEveryone = $bodyData["applies_to_everyone"];
        $this->privilegeRoleLinks = PrivilegeRoleLinkCollection::fromObjects(
            ...array_map(
                fn(array $privilege) => PrivilegeRoleLink::from(
                    PrivilegeNode::from($privilege["node"]),
                    $privilege["affects_all_sub_privileges"],
                    $privilege["is_blacklisted"],
                    isset($privilege["value"]) ? PrivilegeValue::from($privilege["value"]) : null
                ),
                $bodyData["privileges"]
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

    public function getRoleColor(): HexColor
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

    public function getPrivilegeRoleLinks(): PrivilegeRoleLinkCollection
    {
        return $this->privilegeRoleLinks;
    }
}
