<?php

namespace Nebalus\Webapi\Api\Admin\Permission\Get;

use Nebalus\Sanitizr\SanitizrStatic as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Config\Types\RequestParamTypes;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionId;

class GetPermissionValidator extends AbstractValidator
{
    private PermissionId $privilegeId;
    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::PATH_ARGS => S::object([
                "permissionId" => PermissionId::getSchema(),
            ]),
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->privilegeId = PermissionId::from($pathArgsData["permissionId"]);
    }

    public function getPermissionId(): PermissionId
    {
        return $this->privilegeId;
    }
}
