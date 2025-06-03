<?php

namespace Nebalus\Webapi\Api\Admin\Role\Create;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Api\RequestParamTypes;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleAccessLevel;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleDescription;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleName;

class CreateRoleValidator extends AbstractValidator
{
    private RoleName $roleName;
    private ?RoleDescription $roleDescription;
    private bool $appliesToEveryone;
    private RoleAccessLevel $accessLevel;

    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::BODY => [
                "name" => RoleName::getSchema(),
                "description" => RoleDescription::getSchema()->nullable(),
                "applies_to_everyone" => S::boolean(),
                "access_level" => RoleAccessLevel::getSchema(),
            ]
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->roleName = RoleName::from($bodyData["name"]);
        $this->roleDescription = isset($bodyData["description"]) ? RoleDescription::from($bodyData["description"]) : null;
        $this->appliesToEveryone = $bodyData["applies_to_everyone"];
        $this->accessLevel = RoleAccessLevel::from($bodyData["access_level"]);
    }

    public function getRoleName(): RoleName
    {
        return $this->roleName;
    }
    public function getRoleDescription(): ?RoleDescription
    {
        return $this->roleDescription;
    }
    public function appliesToEveryone(): bool
    {
        return $this->appliesToEveryone;
    }
    public function getAccessLevel(): RoleAccessLevel
    {
        return $this->accessLevel;
    }
}
