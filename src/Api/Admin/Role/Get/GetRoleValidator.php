<?php

namespace Nebalus\Webapi\Api\Admin\Role\Get;

use Nebalus\Sanitizr\SanitizrStatic as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Config\Types\RequestParamTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleId;

class GetRoleValidator extends AbstractValidator
{
    private RoleId $roleId;
    private bool $withPermissions;
    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::PATH_ARGS => S::object([
                "role_id" => RoleId::getSchema(),
            ]),
            RequestParamTypes::BODY => S::object([
                "with_permissions" => S::boolean()->default(false),
            ])
        ]));
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws ApiException
     */
    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->roleId = RoleId::from($pathArgsData["role_id"]);
        $this->withPermissions = $bodyData["with_permissions"];
    }

    public function getRoleId(): RoleId
    {
        return $this->roleId;
    }

    public function isWithPermissions(): bool
    {
        return $this->withPermissions;
    }
}
