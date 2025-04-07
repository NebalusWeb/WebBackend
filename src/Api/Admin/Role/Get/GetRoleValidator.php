<?php

namespace Nebalus\Webapi\Api\Admin\Role\Get;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Api\RequestParamTypes;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleName;

class GetRoleValidator extends AbstractValidator
{
    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::PATH_ARGS => S::object([
                "roleName" => S::string()->min(RoleName::MIN_LENGTH)->max(RoleName::MAX_LENGTH),
            ]),
        ]));
    }


    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        // TODO: Implement onValidate() method.
    }
}
