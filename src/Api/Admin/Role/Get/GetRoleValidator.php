<?php

namespace Nebalus\Webapi\Api\Admin\Role\Get;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Api\RequestParamTypes;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleId;

class GetRoleValidator extends AbstractValidator
{
    private RoleId $roleId;
    private bool $withPrivileges;
    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::PATH_ARGS => S::object([
                "roleId" => RoleId::getSchema(),
            ]),
            RequestParamTypes::BODY => S::object([
                "with_privileges" => S::boolean()->optional()->default(false),
            ])
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->roleId = RoleId::from($pathArgsData["roleId"]);
        $this->withPrivileges = $bodyData["with_privileges"];
    }

    public function getRoleId(): RoleId
    {
        return $this->roleId;
    }

    public function isWithPrivileges(): bool
    {
        return $this->withPrivileges;
    }
}
