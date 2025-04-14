<?php

namespace Nebalus\Webapi\Api\Admin\Role\Create;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Api\RequestParamTypes;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleDescription;
use Nebalus\Webapi\Value\User\AccessControl\Role\RoleName;

class CreateRoleValidator extends AbstractValidator
{
    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::BODY => [
                "name" => RoleName::getSchema(),
                "description" => RoleDescription::getSchema()->nullable(),
                "applies_to_everyone" => S::boolean(),
                "access_level" => S::number()->nonNegative(),
            ]
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        // TODO: Implement onValidate() method.
    }
}
