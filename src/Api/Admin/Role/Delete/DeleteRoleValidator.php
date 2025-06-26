<?php

namespace Nebalus\Webapi\Api\Admin\Role\Delete;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Config\Types\RequestParamTypes;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleId;

class DeleteRoleValidator extends AbstractValidator
{
    private RoleId $roleId;
    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::PATH_ARGS => S::object([
                "roleId" => RoleId::getSchema(),
            ])
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->roleId = RoleId::from($pathArgsData["roleId"]);
    }

    public function getRoleId(): RoleId
    {
        return $this->roleId;
    }
}
