<?php

namespace Nebalus\Webapi\Api\Admin\Role\Edit;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Api\RequestParamTypes;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleDescription;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleId;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleName;

class EditRoleValidator extends AbstractValidator
{
    private RoleId $roleId;
    private RoleName $roleName;
    private bool $appliesToEveryone;
    private ?RoleDescription $roleDescription;
    private PrivilegeNodeCollection $privilegeNodes;

    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::PATH_ARGS => S::object([
                "roleId" => RoleId::getSchema(),
            ]),
            RequestParamTypes::BODY => S::object([
                "name" => RoleName::getSchema(),
                "applies_to_everyone" => S::boolean()->default(false),
                "description" => RoleDescription::getSchema()->nullable(),
                "privileges" => S::array(S::object([
                    "node" => S::string()->min(RoleName::MIN_LENGTH)->max(RoleName::MAX_LENGTH),
                    "value" => S::number()->nonNegative()->nullable()->default(null),
                ]))->optional()->nullable()->default([]),
            ])
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        var_dump($bodyData);
        var_dump($queryParamsData);
//        $this->roleId = RoleId::from($bodyData["roleId"]);
//        $this->roleName = RoleName::from($bodyData["roleName"]);
//        $this->appliesToEveryone = $bodyData["applies_to_everyone"];
//        $this->roleDescription = RoleDescription::from($bodyData["description"]);
    }
}
