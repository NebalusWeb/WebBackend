<?php

namespace Nebalus\Webapi\Api\Admin\Role\GetAll;

use Nebalus\Sanitizr\Sanitizr as S;
use Nebalus\Webapi\Api\AbstractValidator;
use Nebalus\Webapi\Api\RequestParamTypes;

class GetAllRoleValidator extends AbstractValidator
{
    private bool $withPermissions;
    public function __construct()
    {
        parent::__construct(S::object([
            RequestParamTypes::BODY => S::object([
                "with_permissions" => S::boolean()->optional()->default(false),
            ])
        ]));
    }

    protected function onValidate(array $bodyData, array $queryParamsData, array $pathArgsData): void
    {
        $this->withPermissions = $bodyData["with_permissions"];
    }

    public function isWithPermissions(): bool
    {
        return $this->withPermissions;
    }
}
